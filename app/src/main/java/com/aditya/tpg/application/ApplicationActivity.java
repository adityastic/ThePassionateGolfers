package com.aditya.tpg.application;

import android.app.Application;

import com.aditya.tpg.R;
import com.aditya.tpg.activities.CrashHandle;
import com.aditya.tpg.utils.typeface.TypefaceUtil;

import cat.ereza.customactivityoncrash.config.CaocConfig;
import uk.co.chrisjenx.calligraphy.CalligraphyConfig;

public class ApplicationActivity extends Application {
    @Override
    public void onCreate() {
        super.onCreate();
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
