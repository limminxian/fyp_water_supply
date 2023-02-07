package com.example.technician;

public class TaskModel {
    int ticketID;
    String name;
    String type;
    String description;
    String street;
    String blockNo;
    String unitNo;
    int postalCode;
    String status;
    String area;

    public TaskModel(int ticketID, String name, String type, String description, String street, String blockNo, String unitNo, int postalCode, String status, String area) {
        this.ticketID = ticketID;
        this.name = name;
        this.type = type;
        this.description = description;
        this.street = street;
        this.blockNo = blockNo;
        this.unitNo = unitNo;
        this.postalCode = postalCode;
        this.status = status;
        this.area = area;
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

    public String getArea() {return area;}

    public void setArea(String area) {
        this.area = area;
    }

    public int getTicketID() {
        return ticketID;
    }

    public void setStatus(String status) {
        this.status = status;
    }
}
