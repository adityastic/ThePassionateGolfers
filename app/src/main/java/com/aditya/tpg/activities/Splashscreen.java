package com.aditya.tpg.activities;

import android.animation.Animator;
import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.view.Menu;
import android.view.View;
import android.view.ViewAnimationUtils;
import android.view.animation.AccelerateDecelerateInterpolator;
import android.widget.ImageView;

import com.aditya.tpg.R;

public class Splashscreen extends Activity {

    /** Duration of wait **/
    private final int SPLASH_DISPLAY_LENGTH = 100;

    /** Called when the activity is first created. */
    @Override
    public void onCreate(Bundle icicle) {
        super.onCreate(icicle);
        setContentView(R.layout.activity_splash);

        final ImageView image = findViewById(R.id.splashscreen);

        image.post(new Runnable() {
            @Override
            public void run() {
                int cx = (int) ((image.getLeft() + image.getRight()) * Math.random());
                int cy = (int) ((image.getTop() + image.getBottom()) * Math.random());

                // get the final radius for the clipping circle
                int dx = Math.max(cx, image.getWidth() - cx);
                int dy = Math.max(cy, image.getHeight() - cy);
                float finalRadius = (float) Math.hypot(dx, dy);

                Animator animator = null;
                if (android.os.Build.VERSION.SDK_INT >= android.os.Build.VERSION_CODES.LOLLIPOP) {
                    animator = ViewAnimationUtils.createCircularReveal(image, cx, cy, 0, finalRadius);
                    animator.setInterpolator(new AccelerateDecelerateInterpolator());
                    animator.setDuration(1000);
                    animator.addListener(new Animator.AnimatorListener() {
                        @Override
                        public void onAnimationStart(Animator animation) {

                        }

                        @Override
                        public void onAnimationEnd(Animator animation) {
                            new Handler().postDelayed(new Runnable(){
                                @Override
                                public void run() {
                                    /* Create an Intent that will start the Menu-Activity. */
                                    startActivity(new Intent(Splashscreen.this,MainActivity.class));
                                }
                            }, SPLASH_DISPLAY_LENGTH);
                        }

                        @Override
                        public void onAnimationCancel(Animator animation) {

                        }

                        @Override
                        public void onAnimationRepeat(Animator animation) {

                        }
                    });
                    animator.start();
                }
                image.setVisibility(View.VISIBLE);
            }
        });
    }
}