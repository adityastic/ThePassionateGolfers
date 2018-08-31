package com.aditya.tpg.application;

import android.app.Application;
import android.content.Context;

import com.aditya.tpg.R;
import com.aditya.tpg.activities.CrashHandle;
import com.aditya.tpg.utils.typeface.TypefaceUtil;
import com.android.volley.RequestQueue;
import com.android.volley.toolbox.Volley;

import cat.ereza.customactivityoncrash.config.CaocConfig;
import uk.co.chrisjenx.calligraphy.CalligraphyConfig;

public class ApplicationActivity extends Application {

    public static RequestQueue mRequestQueue;

    @Override
    public void onCreate() {
        super.onCreate();

        mRequestQueue = Volley.newRequestQueue(getApplicationContext());

        TypefaceUtil.overrideFont(getApplicationContext(), "SERIF", "fonts/circular_std_black.otf"); // font from assets: "assets/fonts/Roboto-Regular.ttf


        CalligraphyConfig.initDefault(new CalligraphyConfig.Builder()
                .setDefaultFontPath("fonts/circular_std_book.otf")
                .setFontAttrId(R.attr.fontPath)
                .build()
        );

        // Custom Activity on Crash initialization
        CaocConfig.Builder.create()
                .backgroundMode(CaocConfig.BACKGROUND_MODE_SHOW_CUSTOM)
                .enabled(true)
                .showErrorDetails(true)
                .showRestartButton(true)
                .trackActivities(true)
                .minTimeBetweenCrashesMs(1)
                .errorActivity(CrashHandle.class)
                .apply();
    }
}
