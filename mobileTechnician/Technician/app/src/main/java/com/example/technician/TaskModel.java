package com.example.technician;

public class TaskModel {
    String street;
    String blockNo;
    String unitNo;
    int postalCode;
    String name;
    String status;
    String description;
    String type;


    public TaskModel(String street, String blockNo, String unitNo, int postalCode, String name, String status, String description, String type) {
        this.street = street;
        this.blockNo = blockNo;
        this.unitNo = unitNo;
        this.postalCode = postalCode;
        this.name = name;
        this.status = status;
        this.description = description;
        this.type = type;
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

    public String getName() {
        return name;
    }

    public String getStatus() {
        return status;
    }

    public String getDescription() {
        return description;
    }

    public String getType() {
        return type;
    }
}
