package com.aditya.tpg.activities;

import android.app.Activity;
import android.content.ClipData;
import android.content.ClipboardManager;
import android.content.Context;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.view.View;
import android.widget.Button;
import android.widget.Toast;

import com.aditya.tpg.R;
import com.aditya.tpg.utils.Common;

import java.util.Arrays;
import java.util.List;

import butterknife.BindView;
import butterknife.ButterKnife;
import cat.ereza.customactivityoncrash.CustomActivityOnCrash;
import cat.ereza.customactivityoncrash.config.CaocConfig;

public class CrashHandle extends Activity {

    @BindView(R.id.email)
    Button emailButton;
    @BindView(R.id.log)
    Button logButton;
    @BindView(R.id.restart)
    Button restart;
//
//    public static final String[] SYSTEM_FAULT_EXCEPTIONS = {
//            "null object reference",
//            "null object",
//            "not attached to Activity",
//            "not attached"
//    };

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        CaocConfig caocConfig = CustomActivityOnCrash.getConfigFromIntent(getIntent());

        setContentView(R.layout.acitivty_crash);
        ButterKnife.bind(this);
        String stacktrace = createErrorReport(getIntent());

        emailButton.setOnClickListener(v -> {
            Intent i = new Intent(Intent.ACTION_SEND);
            i.setType("message/rfc822");
            i.putExtra(Intent.EXTRA_EMAIL, new String[]{"adityaofficialgupta@gmail.com"});
            i.putExtra(Intent.EXTRA_SUBJECT, "TPG App " + Common.getAppVersion(CrashHandle.this, getPackageName()) + " Crash Report");
            i.putExtra(Intent.EXTRA_TEXT, stacktrace);
            try {
                startActivity(Intent.createChooser(i, "Send mail..."));
            } catch (android.content.ActivityNotFoundException ex) {
                Toast.makeText(CrashHandle.this, "There are no email clients installed.", Toast.LENGTH_SHORT).show();
            }
        });

        logButton.setOnClickListener(v -> {
            copyToClipboard(getApplicationContext(),
                    getString(R.string
                            .customactivityoncrash_error_activity_error_details_clipboard_label),
                    stacktrace);
            Toast.makeText(this,
                    R.string.customactivityoncrash_error_activity_error_details_copied,
                    Toast.LENGTH_SHORT).show();

        });

        restart.setOnClickListener(v -> {
            Intent intent = new Intent(CrashHandle.this, Splashscreen.class);
            CustomActivityOnCrash.restartApplicationWithIntent(
                    CrashHandle.this,
                    intent,
                    caocConfig);
        });
    }

    public static void copyToClipboard(Context context,
                                       CharSequence id,
                                       CharSequence content) {
        ClipboardManager clipboard =
                (ClipboardManager) context.getSystemService(CLIPBOARD_SERVICE);
        ClipData clip = ClipData.newPlainText(id, content);
        if (clipboard != null) {
            clipboard.setPrimaryClip(clip);
        }
    }

    public static boolean containsAny(String str, String[] words) {
        boolean bResult = false; // will be set, if any of the words are found
        //String[] words = {"word1", "word2", "word3", "word4", "word5"};

        List<String> list = Arrays.asList(words);
        for (String word : list) {
            boolean bFound = str.contains(word);
            if (bFound) {
                bResult = bFound;
                break;
            }
        }
        return bResult;
    }

    private String createErrorReport(Intent intent) {
        String versionName = Common.getAppVersion(this, getPackageName());
        String details = "";

        details += "Build version: " + versionName + '\n';
        details += "Device: " + Build.MODEL + " (" + Build.DEVICE + ") " + '[' + Build.FINGERPRINT +
                ']';

        details += "Theme system: ";
        details += "\n\n";

        details += "Stack trace:\n";
        details += CustomActivityOnCrash.getStackTraceFromIntent(intent);

        String activityLog = CustomActivityOnCrash.getActivityLogFromIntent(intent);
        if (activityLog != null) {
            details += "\n\nUser actions:\n";
            details += activityLog;
        }

        return details;
    }
}
