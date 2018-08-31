package com.aditya.tpg.datas;

public class MemberData {
    int id;
    String shortname,name;
    int handicap;

    public MemberData(int id, String shortName, String name, int handicap) {
        this.id = id;
        this.shortname = shortName;
        this.name = name;
        this.handicap = handicap;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getShortName() {
        return shortname;
    }

    public void setShortName(String shortName) {
        this.shortname = shortName;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public int getHandicap() {
        return handicap;
    }

    public void setHandicap(int handicap) {
        this.handicap = handicap;
    }
}
