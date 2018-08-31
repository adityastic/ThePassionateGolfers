package com.aditya.tpg.fragments;

import android.annotation.SuppressLint;
import android.content.Context;
import android.graphics.Typeface;
import android.os.Build;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.Html;
import android.util.DisplayMetrics;
import android.util.Log;
import android.util.TypedValue;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.ViewTreeObserver;
import android.view.inputmethod.InputMethodManager;
import android.widget.EditText;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.aditya.tpg.R;
import com.aditya.tpg.adapters.HoleFragmentAdapter;
import com.aditya.tpg.utils.Common;
import com.aditya.tpg.utils.typeface.TypefaceHelper;

public class HoleFragment extends Fragment {

    TextView holen,parn,indexn;
    int index;
//    OnButtonClickListener onButtonClickListener;

    @SuppressLint("StaticFieldLeak")
    public static RecyclerView mRecyclerView;
    public HoleFragmentAdapter mAdapter = null;

    public static HoleFragment newInstance(int index) {
        HoleFragment holeFragment = new HoleFragment();
        holeFragment.index = index;
        return holeFragment;
    }

    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_score, container, false);
    }

    @Override
    public void onViewCreated(final View view, @Nullable Bundle savedInstanceState) {
        Typeface typefaceBold = TypefaceHelper.get(getContext(), getResources().getString(R.string.sans_bold));

        view.findViewById(R.id.recycleRelative).getViewTreeObserver().addOnGlobalLayoutListener(new ViewTreeObserver.OnGlobalLayoutListener() {
            @Override
            public void onGlobalLayout() {
                view.findViewById(R.id.recycleRelative).getViewTreeObserver().removeOnGlobalLayoutListener(this);
                mAdapter.setParentIndex(view.findViewById(R.id.recycleRelative).getHeight());
            }
        });

        holen = view.findViewById(R.id.holeNumber);
        parn = view.findViewById(R.id.parNumber);
        indexn = view.findViewById(R.id.indexNumber);

        holen.setText((index+1)+"");
        parn.setText(Common.tournaments.getCourse().getHoles().get(index).getPar()+"");
        indexn.setText(Common.tournaments.getCourse().getHoles().get(index).getStrin()+"");

        holen.setTypeface(typefaceBold);
        parn.setTypeface(typefaceBold);
        indexn.setTypeface(typefaceBold);


        ((TextView) view.findViewById(R.id.name)).setText(Html.fromHtml("H<sup>cap</sup>"));

        mRecyclerView = view.findViewById(R.id.recyclerView);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(getContext()));

        mAdapter = new HoleFragmentAdapter(getContext(), Common.playerNames, index, ((RelativeLayout) view.findViewById(R.id.recycleRelative)).getHeight());
        mRecyclerView.setAdapter(mAdapter);
        super.onViewCreated(view, savedInstanceState);
    }

    @Override
    public void onResume() {
        super.onResume();
    }

}
