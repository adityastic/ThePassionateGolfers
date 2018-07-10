package com.aditya.tpg.datas;

import org.json.JSONArray;

import java.util.ArrayList;

public class ScoreBoard {
    public ArrayList<PlayerScore> Score;

    public ScoreBoard(ArrayList<PlayerScore> score) {
        this.Score = score;
    }

    @Override
    public String toString() {
        JSONArray jsonArray = new JSONArray();
        for (PlayerScore player: Score) {
            jsonArray.put(player.toString());
        }
        return jsonArray.toString();
    }
}
