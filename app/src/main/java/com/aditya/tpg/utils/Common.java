package com.aditya.tpg.utils;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageInfo;
import android.graphics.PorterDuff;
import android.graphics.PorterDuffColorFilter;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Build;
import android.os.Handler;
import android.os.Message;
import android.os.Messenger;
import android.support.v7.view.menu.ActionMenuItemView;
import android.support.v7.widget.ActionMenuView;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.widget.ImageButton;

import com.aditya.tpg.datas.ScoreBoard;
import com.aditya.tpg.datas.Tournament;
import com.aditya.tpg.services.Downloader;
import com.aditya.tpg.utils.json.ReadJsonFile;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.File;
import java.util.ArrayList;

public class Common {

    public static final String IP = "http://tpg.asln.in";
    public static final String TOURNAMENTS_LINK = IP + "/APITournaments.php";
    public static final String DATE_LINK = IP + "/APIDate.php";
    public static final String UPLOAD_SCORE = IP + "/APIScore.php?id=%s";
    public static final String LEADERBOARD = IP + "/APILeaderboard.php?id=%s";

    public static ArrayList<String> playerNames;
    public static ScoreBoard scoreBoard;

    public static Tournament tournaments;


    public static String getAppVersion(Context context,
                                       String package_name) {
        try {
            PackageInfo pInfo = context.getPackageManager().getPackageInfo(package_name, 0);
            return pInfo.versionName;
        } catch (Exception e) {
            // Suppress warning
        }
        return null;
    }
    
    public static boolean isNetworkAvailable(Context context) {
        ConnectivityManager connectivityManager
                = (ConnectivityManager) context.getSystemService(
                Context.CONNECTIVITY_SERVICE);
        NetworkInfo activeNetworkInfo = connectivityManager.getActiveNetworkInfo();
        return activeNetworkInfo != null && activeNetworkInfo.isConnected();
    }

    public static void startDownload(Context context, String link, String name, Handler handler) {

        File folders = new File(context.getCacheDir(), "/alljsons/");
        if (!folders.exists()) {
            folders.mkdirs();
        }

        Intent intent = new Intent(context.getApplicationContext(), Downloader.class);
        intent.putExtra("link", link);
        intent.putExtra("filename", name);
        intent.putExtra(Downloader.EXTRA_MESSENGER, new Messenger(handler));
        context.startService(intent);
    }

    @SuppressLint("HandlerLeak")
    public static void getTournaments(final Context context, final onGotJSON onGotJSON) {
        final String jsonFile = "Tournaments.json";
        startDownload(context, TOURNAMENTS_LINK, jsonFile, new Handler() {

            @Override
            public void handleMessage(Message msg) {
                if (msg.toString().contains("arg1=1")) {
                    try {
                        JSONArray tournamentJSONArray = new JSONArray(ReadJsonFile.getJSONArray(context.getCacheDir() + "/alljsons/" + jsonFile).toString());
                        onGotJSON.gotJSON(tournamentJSONArray);
                    } catch (Exception e) {
                        e.printStackTrace();
                        onGotJSON.failedJSON(e);
                    }
                }else
                    onGotJSON.failedJSON(new Exception("Arg not 1"));
            }
        });
    }

    @SuppressLint("HandlerLeak")
    public static void getDate(final Context context, final onGotJSON onGotJSON) {
        final String jsonFile = "Date.json";
        startDownload(context, DATE_LINK, jsonFile, new Handler() {

            @Override
            public void handleMessage(Message msg) {
                if (msg.toString().contains("arg1=1")) {
                    try {
                        JSONObject tournamentJSONArray = new JSONObject(ReadJsonFile.getJSONObject(context.getCacheDir() + "/alljsons/" + jsonFile).toString());
                        onGotJSON.gotJSON(tournamentJSONArray);
                    } catch (Exception e) {
                        e.printStackTrace();
                        onGotJSON.failedJSON(e);
                    }
                }else
                    onGotJSON.failedJSON(new Exception("Arg not 1"));
            }
        });
    }

    @SuppressLint("HandlerLeak")
    public static void getLeaderboard(final Context context, final onGotJSON onGotJSON, String id) {
        final String jsonFile = "Leaderboard.json";
        startDownload(context, String.format(LEADERBOARD,id), jsonFile, new Handler() {

            @Override
            public void handleMessage(Message msg) {
                if (msg.toString().contains("arg1=1")) {
                    try {
                        JSONArray tournamentJSONArray = new JSONArray(ReadJsonFile.getJSONArray(context.getCacheDir() + "/alljsons/" + jsonFile).toString());
                        onGotJSON.gotJSON(tournamentJSONArray);
                    } catch (Exception e) {
                        e.printStackTrace();
                        onGotJSON.failedJSON(e);
                    }
                }else
                    onGotJSON.failedJSON(new Exception("Arg not 1"));
            }
        });
    }

    public static void trimCache(Context context) {
        try {
            File dir = context.getCacheDir();
            if (dir != null && dir.isDirectory()) {
                deleteDir(dir);
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public static boolean deleteDir(File dir) {
        if (dir != null && dir.isDirectory()) {
            String[] children = dir.list();
            for (int i = 0; i < children.length; i++) {
                boolean success = deleteDir(new File(dir, children[i]));
                if (!success) {
                    return false;
                }
            }
        }

        return dir.delete();
    }

    public interface onGotJSON{
        void gotJSON(JSONArray jsonArray) throws JSONException;
        void gotJSON(JSONObject jsonObject);
        void failedJSON(Exception e);
    }


    public static void setLightStatusbar(Activity activity, boolean enabled) {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
            final View decorView = activity.getWindow().getDecorView();
            final int systemUiVisibility = decorView.getSystemUiVisibility();
            if (enabled) {
                decorView.setSystemUiVisibility(systemUiVisibility | View.SYSTEM_UI_FLAG_LIGHT_STATUS_BAR);
            } else {
                decorView.setSystemUiVisibility(systemUiVisibility & ~View.SYSTEM_UI_FLAG_LIGHT_STATUS_BAR);
            }
        }
    }

    public static void colorizeToolbar(Toolbar toolbarView, int toolbarIconsColor, Activity activity) {
        final PorterDuffColorFilter colorFilter = new PorterDuffColorFilter(toolbarIconsColor, PorterDuff.Mode.MULTIPLY);

        for (int i = 0; i < toolbarView.getChildCount(); i++) {
            final View v = toolbarView.getChildAt(i);

            //Step 1 : Changing the color of back button (or open drawer button).
            if (v instanceof ImageButton) {
                //Action Bar back button
                ((ImageButton) v).getDrawable().setColorFilter(colorFilter);
            }


            if (v instanceof ActionMenuView) {
                for (int j = 0; j < ((ActionMenuView) v).getChildCount(); j++) {

                    //Step 2: Changing the color of any ActionMenuViews - icons that are not back button, nor text, nor overflow menu icon.
                    //Colorize the ActionViews -> all icons that are NOT: back button | overflow menu
                    final View innerView = ((ActionMenuView) v).getChildAt(j);
                    if (innerView instanceof ActionMenuItemView) {
                        for (int k = 0; k < ((ActionMenuItemView) innerView).getCompoundDrawables().length; k++) {
                            if (((ActionMenuItemView) innerView).getCompoundDrawables()[k] != null) {
                                final int finalK = k;

                                //Important to set the color filter in seperate thread, by adding it to the message queue
                                //Won't work otherwise.
                                innerView.post(new Runnable() {
                                    @Override
                                    public void run() {
                                        ((ActionMenuItemView) innerView).getCompoundDrawables()[finalK].setColorFilter(colorFilter);
                                    }
                                });
                            }
                        }
                    }
                }
            }

            //Step 3: Changing the color of title and subtitle.
            toolbarView.setTitleTextColor(toolbarIconsColor);
            toolbarView.setSubtitleTextColor(toolbarIconsColor);
        }
    }

}
