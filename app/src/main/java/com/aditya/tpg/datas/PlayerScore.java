package com.aditya.tpg.datas;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class PlayerScore {
    public String shortname;
    public ArrayList<Integer> score;

    public PlayerScore(String shortname, ArrayList<Integer> score) {
        this.shortname = shortname;
        this.score = score;
    }

    public void generateScore(int holes) {
        for (int i = 0; i < holes; i++) {
            score.add(-1);
        }
    }

    @Override
    public String toString() {
        JSONArray mJSONArray = new JSONArray();
        for (Integer i : score) {
            mJSONArray.put(i);
        }
        JSONObject mJSONObject = new JSONObject();
        try {
            mJSONObject.put(shortname, mJSONArray);
        } catch (JSONException e) {
            e.printStackTrace();
        }
        return mJSONObject.toString();
    }
}
