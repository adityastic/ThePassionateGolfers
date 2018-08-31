package com.aditya.tpg.datas;

import org.json.JSONException;
import org.json.JSONObject;

public class Holes {
    int par, strin;

    public Holes(int par, int strin) {
        this.par = par;
        this.strin = strin;
    }

    public int getPar() {
        return par;
    }

    public void setPar(int par) {
        this.par = par;
    }

    public int getStrin() {
        return strin;
    }

    @Override
    public String toString() {

        JSONObject jsonObject = new JSONObject();
        try {
            jsonObject.put("par", par);
            jsonObject.put("strin", strin);
        } catch (JSONException e) {
            e.printStackTrace();
        }

        return jsonObject.toString();
    }
}
