package com.aditya.tpg.utils;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.content.Context;
import android.content.pm.PackageInfo;
import android.graphics.PorterDuff;
import android.graphics.PorterDuffColorFilter;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import androidx.appcompat.view.menu.ActionMenuItemView;
import androidx.appcompat.widget.ActionMenuView;
import androidx.appcompat.widget.Toolbar;
import android.view.View;
import android.widget.ImageButton;

import com.aditya.tpg.application.ApplicationActivity;
import com.aditya.tpg.datas.ScoreBoard;
import com.aditya.tpg.datas.Tournament;
import com.android.volley.Request;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.JsonObjectRequest;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class Common {

//    public static final String IP = "http://tpg.asln.in";
    public static final String IP = "http://192.168.43.52/tpg/";

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

    @SuppressLint("HandlerLeak")
    public static void getTournaments(final onGotJSON onGotJSON) {

        JsonArrayRequest jsonArrayRequest = new JsonArrayRequest(Request.Method.GET, TOURNAMENTS_LINK, null, response -> {
            try {
                onGotJSON.gotJSON(response);
            } catch (JSONException e) {
                onGotJSON.failedJSON(e);
            }
        }, error -> onGotJSON.failedJSON(new Exception(error.toString()))
        );

        // Add JsonArrayRequest to the RequestQueue
        ApplicationActivity.mRequestQueue.add(jsonArrayRequest);
    }

    @SuppressLint("HandlerLeak")
    public static void getDate(final onGotJSON onGotJSON) {


        JsonObjectRequest jsonObjectRequest = new JsonObjectRequest(Request.Method.GET, DATE_LINK, null, onGotJSON::gotJSON, error -> onGotJSON.failedJSON(new Exception(error.toString()))
        );

        // Add JsonObjectRequest to the RequestQueue
        ApplicationActivity.mRequestQueue.add(jsonObjectRequest);
    }

    @SuppressLint("HandlerLeak")
    public static void getLeaderboard(final onGotJSON onGotJSON, String id) {

        JsonArrayRequest jsonArrayRequest = new JsonArrayRequest(Request.Method.GET, String.format(LEADERBOARD,id), null, response -> {
            try {
                onGotJSON.gotJSON(response);
            } catch (JSONException e) {
                onGotJSON.failedJSON(e);
            }
        }, error -> onGotJSON.failedJSON(new Exception(error.toString()))
        );

        // Add JsonArrayRequest to the RequestQueue
        ApplicationActivity.mRequestQueue.add(jsonArrayRequest);
    }


    public interface onGotJSON {
        void gotJSON(JSONArray jsonArray) throws JSONException;

        void gotJSON(JSONObject jsonObject);

        void failedJSON(Exception e);
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
                                innerView.post(() -> ((ActionMenuItemView) innerView).getCompoundDrawables()[finalK].setColorFilter(colorFilter));
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
