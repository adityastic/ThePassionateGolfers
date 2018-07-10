package com.aditya.tpg.activities;

import android.animation.Animator;
import android.animation.AnimatorListenerAdapter;
import android.app.SearchManager;
import android.content.Intent;
import android.content.SharedPreferences;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.graphics.Color;
import android.graphics.Typeface;
import android.os.Build;
import android.preference.PreferenceManager;
import android.support.annotation.RequiresApi;
import android.support.v4.view.MenuItemCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.AppCompatTextView;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.SearchView;
import android.support.v7.widget.Toolbar;
import android.text.Html;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewAnimationUtils;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.aditya.tpg.R;
import com.aditya.tpg.adapters.MembersAdapter;
import com.aditya.tpg.datas.MemberData;
import com.aditya.tpg.utils.Common;
import com.aditya.tpg.utils.sqlite.DBHelper;
import com.getkeepsafe.taptargetview.TapTarget;
import com.getkeepsafe.taptargetview.TapTargetView;
import com.miguelcatalan.materialsearchview.MaterialSearchView;

import java.lang.reflect.Field;
import java.util.ArrayList;
import java.util.List;


public class SelectMembersActivity extends AppCompatActivity implements MaterialSearchView.OnQueryTextListener {

    Toolbar mToolbar;
    RecyclerView mRecyclerView;
    MembersAdapter mAdapter;
    MaterialSearchView searchView;

    String searchString = "";

    SharedPreferences prefs;

    @Override
    public void onBackPressed() {
        if (searchView.isSearchOpen()) {
            searchView.closeSearch();
        } else {
            finishAffinity();
            startActivity(new Intent(this,MainActivity.class));
        }
    }

    ArrayList<MemberData> searchlist;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_selectmembers);

        mToolbar = findViewById(R.id.toolbar);

        setUpToolbar();

        prefs= PreferenceManager.getDefaultSharedPreferences(this);

        ((AppCompatTextView) findViewById(R.id.handicap)).setText(Html.fromHtml("H<sup>cap</sup>"));

        mRecyclerView = findViewById(R.id.recyclerView);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(this));

        searchlist = new ArrayList<>();
        refreshLayout();
        MembersAdapter.setMemberSelected();
        mAdapter = new MembersAdapter(searchlist, this);

        SQLiteDatabase readdatabase = DBHelper.dbHelper.getReadableDatabase();
        SQLiteDatabase writedatabase = DBHelper.dbHelper.getWritableDatabase();
        Cursor cursor = readdatabase.rawQuery("SELECT * FROM tbgolftournament", null);
        if (cursor.getCount() != 0) {
            MembersAdapter.memberSelected = Common.playerNames;
            writedatabase.delete("tbgolftournament", "gtid = " + Common.tournaments.getId(), null);
        }

        mRecyclerView.setAdapter(mAdapter);

        ((Button) findViewById(R.id.onTakeAttendance)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (mAdapter.getSelectedList().size() < 1) {
                    Toast.makeText(SelectMembersActivity.this, "Select atleast 1 members to play", Toast.LENGTH_SHORT).show();
                } else {
                    Common.playerNames = mAdapter.getSelectedList();
                    Intent i = new Intent(SelectMembersActivity.this, ScoreboardActivity.class);
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
                searchView.setOnQueryTextListener(SelectMembersActivity.this);
                searchString = "";
                refreshLayout();
            }

            @Override
            public void onSearchViewClosed() {
                //Do some magic
            }
        });

        if (prefs.getBoolean("firstrun", true)) {
            TapTargetView.showFor(SelectMembersActivity.this,                 // `this` is an Activity
                    TapTarget.forView(findViewById(R.id.subTitle), "You can select maximum 4 and minimum 2 players to play the tournament", "")
                            // All options below are optional
                            .outerCircleColor(R.color.colorAccent)      // Specify a color for the outer circle
                            .targetCircleColor(R.color.white)   // Specify a color for the target circle
                            .titleTextSize(20)                  // Specify the size (in sp) of the title text
                            .titleTextColor(R.color.white)      // Specify the color of the title text
                            .textColor(R.color.bg)            // Specify a color for both the title and description text
                            .textTypeface(Typeface.SANS_SERIF)  // Specify a typeface for the text
                            .dimColor(R.color.black)            // If set, will dim behind the view with 30% opacity of the given color
                            .drawShadow(true)                   // Whether to draw a drop shadow or not
                            .cancelable(true)                  // Whether tapping outside the outer circle dismisses the view
                            .tintTarget(false)                   // Whether to tint the target view's color
                            .transparentTarget(false)               // Specify a custom drawable to draw as the target
                            .targetRadius(150),                  // Specify the target radius (in dp)
                    new TapTargetView.Listener() {          // The listener can listen for regular clicks, long clicks or cancels
                        @Override
                        public void onTargetClick(TapTargetView view) {
                            super.onTargetClick(view);
                        }
                    });
            prefs.edit().putBoolean("firstrun", false).apply();
        }
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

        mAdapter = new MembersAdapter(searchlist, SelectMembersActivity.this);
        mRecyclerView.setAdapter(mAdapter);

    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_member, menu);

        MenuItem item = menu.findItem(R.id.action_search);
        searchView.setMenuItem(item);

        return true;
    }

    private void setUpToolbar() {
        setTitle("");
        setSupportActionBar(mToolbar);

        mToolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onBackPressed();
            }
        });

        //noinspection ConstantConditions
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        if(item.getItemId() == R.id.reset)
        {
            MembersAdapter.setMemberSelected();
            mAdapter.notifyDataSetChanged();
        }
        return super.onOptionsItemSelected(item);
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
}
