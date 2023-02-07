package com.example.technician;

public class WaterModel {
    int homeownerId;
    String street;
    String blockNo;
    String unitNo;
    int postalCode;
    float waterUsage;
    String area;
    String houseType;


    public WaterModel(int homeownerId, String street, String blockNo, String unitNo, int postalCode, float waterUsage, String area, String houseType) {
        this.homeownerId = homeownerId;
        this.street = street;
        this.blockNo = blockNo;
        this.unitNo = unitNo;
        this.postalCode = postalCode;
        this.waterUsage = waterUsage;
        this.area = area;
        this.houseType = houseType;
    }

    public int getHomeownerId() {
        return homeownerId;
    }

    public String getStreet() {
        return street;
    }

    public String getBlockNo() {
        return blockNo;
    }

    public String getUnitNo() {
        return unitNo;
    }

    public int getPostalCode() {
        return postalCode;
    }

    public String getArea() {
        return area;
    }

    public String getHouseType() {
        return houseType;
    }

    public float getWaterUsage() {
        return waterUsage;
    }

    public void setWaterUsage(float waterUsage) {
        this.waterUsage = waterUsage;
    }

}
