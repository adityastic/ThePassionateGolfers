package com.aditya.tpg.activities;

import android.animation.Animator;
import android.animation.AnimatorListenerAdapter;
import android.annotation.TargetApi;
import android.content.Intent;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.os.Handler;
import android.support.annotation.NonNull;
import android.support.design.widget.AppBarLayout;
import android.support.design.widget.CollapsingToolbarLayout;
import android.support.design.widget.CoordinatorLayout;
import android.support.design.widget.FloatingActionButton;
import android.support.v4.widget.NestedScrollView;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.AppCompatTextView;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.Toolbar;
import android.text.Html;
import android.util.DisplayMetrics;
import android.util.Log;
import android.util.TypedValue;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewAnimationUtils;
import android.view.ViewTreeObserver;
import android.view.Window;
import android.view.WindowManager;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.aditya.tpg.Views.SheetDialog;
import com.aditya.tpg.adapters.MembersAdapter;
import com.aditya.tpg.datas.MemberData;
import com.aditya.tpg.listeners.AppBarStateChangeListener;
import com.aditya.tpg.R;
import com.aditya.tpg.utils.Common;
import com.miguelcatalan.materialsearchview.MaterialSearchView;

import java.util.ArrayList;

import static android.view.View.GONE;

public class CourseInfoActivity extends AppCompatActivity implements MaterialSearchView.OnQueryTextListener {

    FloatingActionButton fab;
    boolean fabclose;
    Button button;

    Toolbar toolbar;
    AppBarLayout appbar;
    CollapsingToolbarLayout toolbarLayout;

    MenuItem searchIcon;
    MaterialSearchView searchView;

    RecyclerView mRecyclerView;
    MembersAdapter mAdapter;
    ArrayList<MemberData> searchlist;

    @Override
    public void onBackPressed() {
        if (searchView.isSearchOpen()) {
            hide(searchView, new Animator.AnimatorListener() {
                @Override
                public void onAnimationStart(Animator animation) {

                }

                @Override
                public void onAnimationEnd(Animator animation) {
                    searchView.closeSearch();
                }

                @Override
                public void onAnimationCancel(Animator animation) {

                }

                @Override
                public void onAnimationRepeat(Animator animation) {

                }
            });
        } else {
            super.onBackPressed();
        }
    }

    int index;
    String searchString = "";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_courseinfo);

        index = getIntent().getExtras().getInt("Index");

        setDrawUnderStatusbar(true);
        toolbar = findViewById(R.id.toolbar);
        appbar = findViewById(R.id.appbar);
        appbar.getViewTreeObserver().addOnGlobalLayoutListener(new ViewTreeObserver.OnGlobalLayoutListener() {
            @Override
            public void onGlobalLayout() {
                DisplayMetrics displayMetrics = new DisplayMetrics();
                getWindowManager().getDefaultDisplay().getMetrics(displayMetrics);
                int height = displayMetrics.heightPixels;
                appbar.getLayoutParams().height = height/4 + height/16 ;
            }
        });
        toolbarLayout = findViewById(R.id.collapsing_toolbar);

        button = findViewById(R.id.selectPlayers);
        fab = findViewById(R.id.fab);

        fab.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                SheetDialog sheetDialog = new SheetDialog(CourseInfoActivity.this);
                View sheetView =
                        View.inflate(CourseInfoActivity.this, R.layout.bottom_sheet, null);
                TextView textView = sheetView.findViewById(R.id.text);
                textView.setText(Common.tournaments.getCourse().getDesc());

                sheetDialog.setContentView(sheetView);
                sheetDialog.show();
            }
        });

        button.setVisibility(View.INVISIBLE);
        fab.setVisibility(View.INVISIBLE);

        fabclose = false;

        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                int startRadius = 0;
                int cX = fab.getWidth() / 2;
                int cY = fab.getHeight() / 2;
                int endRadius = (int) Math.hypot(fab.getWidth(), fab.getHeight());
                Animator anim = null;
                if (android.os.Build.VERSION.SDK_INT >= android.os.Build.VERSION_CODES.LOLLIPOP) {
                    anim = ViewAnimationUtils.createCircularReveal(fab, cX, cY, startRadius, endRadius);
                    anim.setDuration(500);
                    if (!fabclose) {
                        fab.setVisibility(View.VISIBLE);
                        anim.start();
                    }
                    button.startAnimation(AnimationUtils.loadAnimation(CourseInfoActivity.this, R.anim.slide_from_bottom));
                } else
                    fab.setVisibility(View.VISIBLE);
                button.setVisibility(View.VISIBLE);
            }
        }, 700);

        toolbar = (Toolbar) findViewById(R.id.toolbar);
        appbar.addOnOffsetChangedListener(new AppBarStateChangeListener() {
            @Override
            public void onStateChanged(AppBarLayout appBarLayout, State state) {

                int color;
                switch (state) {
                    case COLLAPSED:
                        if (searchIcon != null)
                            searchIcon.setVisible(true);
                        break;
                    case EXPANDED:
                    case IDLE:
                        if (searchIcon != null)
                            searchIcon.setVisible(false);
                        break;
                }
                color = Color.parseColor("#ffffff");
                toolbarLayout.setExpandedTitleColor(color);
                Common.colorizeToolbar(toolbar, color, CourseInfoActivity.this);
                toolbar.setTitleTextColor(color);
            }

        });
        setTitle(R.string.app_name);
        setSupportActionBar(toolbar);

        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onBackPressed();
            }
        });
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);

        searchView = findViewById(R.id.search_view);
        searchView.setCloseIcon(getResources().getDrawable(R.drawable.ic_close_white_24dp));

        searchView.setOnSearchViewListener(new MaterialSearchView.SearchViewListener() {
            @Override
            public void onSearchViewShown() {
//                searchView.setOnQueryTextListener(SelectMembersActivity.this);
//                searchString = "";
//                refreshLayout();
            }

            @Override
            public void onSearchViewClosed() {
                //Do some magic
            }
        });

        ImageView v = (ImageView) findViewById(R.id.image);

        switch (getIntent().getExtras().getInt("Image")) {
            case 1:
                v.setImageDrawable(getResources().getDrawable(R.drawable.gc1));
                break;
            case 2:
                v.setImageDrawable(getResources().getDrawable(R.drawable.gc2));
                break;
            case 3:
                v.setImageDrawable(getResources().getDrawable(R.drawable.gc3));
                break;
        }

        setTitle(Common.tournaments.getCourse().getName());


        //Select Members
        ((AppCompatTextView) findViewById(R.id.handicap)).setText(Html.fromHtml("H<sup>cap</sup>"));

        mRecyclerView = findViewById(R.id.recyclerView);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(this));
        searchlist = new ArrayList<>();
        refreshLayout();
        MembersAdapter.setMemberSelected();
        mAdapter = new MembersAdapter(searchlist, this);
        mRecyclerView.setAdapter(mAdapter);

        button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (mAdapter.getSelectedList().size() < 1) {
                    Toast.makeText(CourseInfoActivity.this, "Select atleast 1 members to play", Toast.LENGTH_SHORT).show();
                } else {
                    Common.playerNames = mAdapter.getSelectedList();
                    Intent i = new Intent(CourseInfoActivity.this, ScoreboardActivity.class);
                    startActivity(i);
                    overridePendingTransition(R.anim.slide_up, R.anim.stay);
                }
            }
        });

        searchView = findViewById(R.id.search_view);
        searchView.setCloseIcon(getResources().getDrawable(R.drawable.ic_close_white_24dp));

        searchView.setOnSearchViewListener(new MaterialSearchView.SearchViewListener() {
            @Override
            public void onSearchViewShown() {
                searchView.setOnQueryTextListener(CourseInfoActivity.this);
                searchString = "";
                refreshLayout();
                toolbarLayout.setTitle(" ");
                mRecyclerView.setNestedScrollingEnabled(false);
            }

            @Override
            public void onSearchViewClosed() {
                mRecyclerView.setNestedScrollingEnabled(true);
                toolbarLayout.setTitle(Common.tournaments.getCourse().getName());
            }
        });
    }


    public void refreshLayout() {
        searchlist = null;
        mAdapter = null;
        mRecyclerView.setAdapter(null);

        searchlist = new ArrayList<>();
        ArrayList<MemberData> memberData = Common.tournaments.getMembers();

        for (MemberData mem : memberData) {
            if (mem.getShortName().toLowerCase().contains(searchString.toLowerCase()) || mem.getName().toLowerCase().contains(searchString.toLowerCase())) {
                searchlist.add(mem);
            }
        }

        mAdapter = new MembersAdapter(searchlist, CourseInfoActivity.this);
        mRecyclerView.setAdapter(mAdapter);

    }

    protected void setDrawUnderStatusbar(boolean drawUnderStatusbar) {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP)
            setAllowDrawUnderStatusBar(getWindow());
        else if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT)
            setStatusBarTranslucent(getWindow());
    }

    @TargetApi(Build.VERSION_CODES.KITKAT)
    public static void setStatusBarTranslucent(@NonNull Window window) {
        window.setFlags(
                WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS,
                WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS);
    }

    public static void setAllowDrawUnderStatusBar(@NonNull Window window) {
        window.getDecorView().setSystemUiVisibility(
                View.SYSTEM_UI_FLAG_LAYOUT_STABLE
                        | View.SYSTEM_UI_FLAG_LAYOUT_FULLSCREEN);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_member, menu);

        searchIcon = menu.findItem(R.id.action_search);
        searchIcon.setVisible(false);

        searchView.setMenuItem(searchIcon);
        return true;
    }

    @Override
    public boolean onQueryTextSubmit(String query) {
        searchString = query;
        refreshLayout();
        searchView.setOnQueryTextListener(null);
        return false;
    }

    @Override
    public boolean onQueryTextChange(String newText) {
        if (searchView.isSearchOpen()) {
            searchString = newText;
            refreshLayout();

        }
        return false;
    }

    public static void hide(final View view,Animator.AnimatorListener listener) {
        int cx = view.getWidth() - (int) TypedValue.applyDimension(
                TypedValue.COMPLEX_UNIT_DIP, 24, view.getResources().getDisplayMetrics());
        int cy = view.getHeight() / 2;
        int finalRadius = Math.max(view.getWidth(), view.getHeight());

        Animator anim = null;
        if (android.os.Build.VERSION.SDK_INT >= android.os.Build.VERSION_CODES.LOLLIPOP) {
            anim = ViewAnimationUtils.createCircularReveal(view, cx, cy, finalRadius, 0);
        }
        view.setVisibility(View.VISIBLE);
        anim.addListener(listener);
        anim.setDuration(200);
        anim.start();
    }
}
