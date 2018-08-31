package com.aditya.tpg.datas;

import android.util.Log;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;
import java.util.Date;

public class Tournament {
    int id;
    String name, date, time, regdate;
    Course course;
    ArrayList<MemberData> members;

    public Tournament(int id, String name, String date, String regdate, String time, Course course, ArrayList<MemberData> members) {
        this.id = id;
        this.name = name;
        this.regdate = regdate;
        this.date = date;
        this.time = time;
        this.course = course;
        this.members = members;
    }

    public Date getRegdate() throws ParseException {
        return new SimpleDateFormat("yyyy-MM-dd").parse(regdate);
    }

    public void setRegdate(String regdate) {
        this.regdate = regdate;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public String getTime() {
        return time;
    }

    public void setTime(String time) {
        this.time = time;
    }

    public Course getCourse() {
        return course;
    }

    public void setCourse(Course course) {
        this.course = course;
    }

    public ArrayList<MemberData> getMembers() {
        Collections.sort(members, new Comparator<MemberData>() {
            @Override
            public int compare(MemberData o1, MemberData o2) {
                return o1.getName().compareTo(o2.getName());
            }
        });
        return members;
    }

    public void setMembers(ArrayList<MemberData> members) {
        this.members = members;
    }

    public String getGTMembers() {
        JSONArray jsonArray = new JSONArray();
        try {
            for (MemberData mem: members) {
                JSONObject jsonObject = new JSONObject();
                jsonObject.put("id",mem.id);
                jsonObject.put("name",mem.name);
                jsonObject.put("shortname",mem.shortname);
                jsonObject.put("handicap",mem.handicap);
                jsonArray.put(jsonObject);
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }
        return jsonArray.toString();
    }
}
