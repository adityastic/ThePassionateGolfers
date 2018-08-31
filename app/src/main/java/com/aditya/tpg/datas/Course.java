package com.aditya.tpg.datas;

import android.util.Log;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class Course {
    String name,sname,desc,city;
    ArrayList<Holes> holes;

    public Course(String name, String sname, String desc, String city, ArrayList<Holes> holes) {
        this.name = name;
        this.sname = sname;
        this.desc = desc;
        this.city = city;
        this.holes = holes;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getSname() {
        return sname;
    }

    public void setSname(String sname) {
        this.sname = sname;
    }

    public String getDesc() {
        return desc;
    }

    public ArrayList<Holes> getHoles() {
        return holes;
    }

    public void setHoles(ArrayList<Holes> holes) {
        this.holes = holes;
    }

    @Override
    public String toString() {
        JSONObject jsonObject = new JSONObject();
        try {
            jsonObject.put("name",this.name);
            jsonObject.put("sname",this.sname);
            jsonObject.put("description",this.desc);
            jsonObject.put("city",this.city);

            JSONArray jsonArray = new JSONArray();
            for (Holes hole: holes) {
                JSONObject object = new JSONObject();
                object.put("par",hole.par);
                object.put("strin",hole.strin);
                jsonArray.put(object);
            }
            jsonObject.put("holes",jsonArray);

        } catch (JSONException e) {
            e.printStackTrace();
        }
        return jsonObject.toString();
    }
}
