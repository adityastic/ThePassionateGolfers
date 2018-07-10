package com.aditya.tpg.datas;

import java.util.ArrayList;

public class LeaderInfo {
    String sname,name;
    ArrayList<Integer> score;

    public LeaderInfo(String sname, String name, ArrayList<Integer> score) {
        this.sname = sname;
        this.name = name;
        this.score = score;
    }

    public String getSname() {
        return sname;
    }

    public void setSname(String sname) {
        this.sname = sname;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public ArrayList<Integer> getScore() {
        return score;
    }

    public void setScore(ArrayList<Integer> score) {
        this.score = score;
    }

    public int getTotal() {
        int sum=0;
        for (int i: score) {
            sum +=i;
        }
        return sum;
    }
}
