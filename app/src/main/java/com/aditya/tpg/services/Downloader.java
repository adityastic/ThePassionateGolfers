package com.aditya.tpg.services;

/**
 * Created by Aditya on 20/12/16.
 */

import android.app.IntentService;
import android.content.Intent;
import android.os.Bundle;
import android.os.Message;
import android.os.Messenger;
import android.util.Log;

import org.apache.http.client.HttpClient;
import org.apache.http.impl.client.DefaultHttpClient;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;

public class Downloader extends IntentService {
    public static final String EXTRA_MESSENGER = "EXTRA_MESSENGER";
    private HttpClient client = null;

    public Downloader() {
        super("Downloader");
    }

    @Override
    public void onCreate() {
        super.onCreate();

        client = new DefaultHttpClient();
    }

    @Override
    public void onDestroy() {
        super.onDestroy();

        client.getConnectionManager().shutdown();
    }

    @Override
    public void onHandleIntent(Intent i) {

        Bundle extras = i.getExtras();
        Messenger messenger = (Messenger) extras.get(EXTRA_MESSENGER);
        Message msg = Message.obtain();

        String tempfilename = i.getStringExtra("filename");
        String link = i.getStringExtra("link");

        InputStream input = null;
        OutputStream output = null;
        HttpURLConnection connection = null;

        try {
            File last_file = new File(getCacheDir() +
                    "/alljsons/" + tempfilename);

            if (last_file.exists()) {
                tempfilename = tempfilename.substring(0, tempfilename.length() - 5) + "-temp.json";
            }

            URL url = new URL(link);
            connection = (HttpURLConnection) url.openConnection();
            connection.connect();

            // expect HTTP 200 OK, so we don't mistakenly save error report
            // instead of the file
            if (connection.getResponseCode() != HttpURLConnection.HTTP_OK) {
                Log.e("HTTP Error", "Server returned HTTP " + connection.getResponseCode()
                        + " " + connection.getResponseMessage());
            }

            // download the file
            input = connection.getInputStream();

            output = new FileOutputStream(
                    getCacheDir().getAbsolutePath() + "/alljsons/" + tempfilename);
            byte data[] = new byte[4096];
            long total = 0;
            int count;
            while ((count = input.read(data)) != -1) {
                total += count;
                output.write(data, 0, count);
            }
        } catch (Exception e) {
            Log.e("Error in Downloading", e.toString());

            msg.arg1 = 0;

        } finally {
            try {
                if (output != null)
                    output.close();
                if (input != null)
                    input.close();
            } catch (IOException ignored) {
                // Suppress warning
            }

            if (connection != null)
                connection.disconnect();
        }

        if (tempfilename.endsWith("-temp.json")) {
            File renameMe = new File(getCacheDir() +
                    "/alljsons/" + tempfilename);
            boolean rename = renameMe.renameTo(
                    new File(getCacheDir() +
                            "/alljsons/" + tempfilename.substring(0, tempfilename.length() - 10) + ".json"));
            if (!rename) Log.e("Error in " + tempfilename,
                    "Unable to rename temporary file.");

            File deleteMe = new File(getCacheDir() +
                    "/alljsons/" + tempfilename);
            boolean deleted = deleteMe.getAbsoluteFile().delete();
            if (!deleted) Log.e("Error in " + tempfilename,
                    "Unable to delete temporary file.");
        }

        msg.arg1 = 1;

        try {
            messenger.send(msg);
        } catch (android.os.RemoteException e1) {
            Log.w(getClass().getName(), "Exception sending message", e1);
        }

    }
}
