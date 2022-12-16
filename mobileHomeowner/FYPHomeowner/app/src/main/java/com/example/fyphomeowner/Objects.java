package com.example.fyphomeowner;

import android.os.Parcel;
import android.os.Parcelable;

public class Objects {

}

enum Status{
    active,
    inactive,
    notValidated,
    suspended,
    blocked
}

enum Role{
    superAdmin("Super Admin", "Admin account which manages all the accounts in the system"),
    companyAdmin("Company Admin", "An admin account of a registered company which manages all the company accounts"),
    customerService("Customer service Staff", "A Staff account whose role is to manage customer service request and handle maintenance task delegation to technicians"),
    technician("Technician Staff", "A Staff account whose role is to manage equipment, chemicals, and retreiving homeowner water usage levels"),
    homeowner("Homeowner", "A homeowner's account which has access to their respective water usage, profile details, subscription details, and businesses available");

    public final String label;
    public final String description;

    private Role(String label, String description){
        this.label = label;
        this.description = description;
    }

    public String getLabel() {
        return label;
    }

    public String getDescription() {
        return description;
    }

    @Override
    public String toString() {
        return label;
    }
}

enum HouseType{
    oneRoomFlat("1-Room Flat"),
    twoRoomFlat("2-Room Flat"),
    threeRoomFlat("3-Room Flat"),
    fourRoomFlat("4-Room Flat"),
    fiveRoomFlat("5-Room Flat"),
    executiveFlat("Executive Flat"),
    executiveCondo("Executive Condo"),
    privateCondo("Private Condo"),
    apartment("Apartment"),
    semidetached("Semi Detached House"),
    terracce("Terrace House"),
    shophouse("Shop House"),
    bungalow("Bungalow House");

    public final String label;

    private HouseType(String label){
        this.label = label;
    }

    @Override
    public String toString() {
        return label;
    }
}

class User{
    private static int instanceCounter = 0;
    private int ID = 0;
    private String name;
    private String email;
    private String password;
    private Status status;
    private Role type;

    public User(){
        instanceCounter++;
        ID = instanceCounter;
    }

    public User(String name, String email, String password, Status status, Role type) {
        instanceCounter++;
        this.ID = instanceCounter;
        this.name = name;
        this.email = email;
        this.password = password;
        this.status = status;
        this.type = type;
    }

    public User(User user){
        instanceCounter++;
        this.ID = instanceCounter;
        this.name = user.getName();
        this.email = user.getEmail();
        this.password = user.getPassword();
        this.status = user.getStatus();
        this.type = user.getType();
    }

    public static int getInstanceCounter() {
        return instanceCounter;
    }

    public static void setInstanceCounter(int instanceCounter) {
        User.instanceCounter = instanceCounter;
    }

    public int getID() {
        return ID;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public Status getStatus() {
        return status;
    }

    public void setStatus(Status status) {
        this.status = status;
    }

    public Role getType() {
        return type;
    }

    public void setType(Role type) {
        this.type = type;
    }

    @Override
    public String toString() {
        return "user{" +
                "ID=" + ID +
                ", name='" + name + '\'' +
                ", email='" + email + '\'' +
                ", password='" + password + '\'' +
                ", status=" + status +
                ", type=" + type +
                '}';
    }
}

class Homeowner extends User{
    private int phoneNo;
    private String street;
    private String blkNo;
    private String unitNo;
    private int postalCode;
    private HouseType houseType;
    private int householdSize;
    private int subscribedCompanyUEN;

    Homeowner(){
        super();
    }

    public Homeowner(int phoneNo, String street, String blkNo, String unitNo, int postalCode, com.example.fyphomeowner.HouseType houseType, int householdSize, Company subscribedCompany) {
        this.phoneNo = phoneNo;
        this.street = street;
        this.blkNo = blkNo;
        this.unitNo = unitNo;
        this.postalCode = postalCode;
        this.houseType = houseType;
        this.householdSize = householdSize;
        this.subscribedCompanyUEN = subscribedCompany.getUEN();
    }

    public Homeowner(String name, String email, String password, Status status, Role type, int phoneNo, String street, String blkNo, String unitNo,
                     int postalCode, HouseType houseType, int householdSize, Company subscribedCompany) {
        super(name, email, password, status, type);
        this.phoneNo = phoneNo;
        this.street = street;
        this.blkNo = blkNo;
        this.unitNo = unitNo;
        this.postalCode = postalCode;
        this.houseType = houseType;
        this.householdSize = householdSize;
        this.subscribedCompanyUEN = subscribedCompany.getUEN();
    }

    public Homeowner(User user, int phoneNo, String street, String blkNo, String unitNo, int postalCode,
                     com.example.fyphomeowner.HouseType houseType, int householdSize, Company subscribedCompany) {
        super(user);
        this.phoneNo = phoneNo;
        this.street = street;
        this.blkNo = blkNo;
        this.unitNo = unitNo;
        this.postalCode = postalCode;
        this.houseType = houseType;
        this.householdSize = householdSize;
        this.subscribedCompanyUEN = subscribedCompany.getUEN();
    }

    public int getPhoneNo() {
        return phoneNo;
    }

    public void setPhoneNo(int phoneNo) {
        this.phoneNo = phoneNo;
    }

    public String getStreet() {
        return street;
    }

    public void setStreet(String street) {
        this.street = street;
    }

    public String getBlkNo() {
        return blkNo;
    }

    public void setBlkNo(String blkNo) {
        this.blkNo = blkNo;
    }

    public String getUnitNo() {
        return unitNo;
    }

    public void setUnitNo(String unitNo) {
        this.unitNo = unitNo;
    }

    public int getPostalCode() {
        return postalCode;
    }

    public void setPostalCode(int postalCode) {
        this.postalCode = postalCode;
    }

    public com.example.fyphomeowner.HouseType getHouseType() {
        return houseType;
    }

    public void setHouseType(com.example.fyphomeowner.HouseType houseType) {
        this.houseType = houseType;
    }

    public int getHouseholdSize() {
        return householdSize;
    }

    public void setHouseholdSize(int householdSize) {
        this.householdSize = householdSize;
    }

    public int getSubscribedCompanyUEN() {
        return subscribedCompanyUEN;
    }

    public void setCompanySubscribed(Company company) {
        this.subscribedCompanyUEN = company.getUEN();
    }

    @Override
    public String toString() {
        return "Homeowner{" +
                "phoneNo=" + phoneNo +
                ", street='" + street + '\'' +
                ", blkNo=" + blkNo +
                ", unitNo=" + unitNo +
                ", postalCode=" + postalCode +
                ", houseType=" + houseType +
                ", householdSize=" + householdSize +
                ", companySubscribed=" + subscribedCompanyUEN +
                '}';
    }
}

class Company implements Parcelable {
    private int UEN;
    private String name;
    private int PhoneNo;
    private String street;
    private int postalCode;
    private String Description;
    private int noOfStars;
    private User Admin;
    //private File image;

    public Company(){

    }

    public Company(int UEN, String name, int phoneNo, String street, int postalCode, String description, int noOfStars, User admin) {
        this.UEN = UEN;
        this.name = name;
        this.PhoneNo = phoneNo;
        this.street = street;
        this.postalCode = postalCode;
        this.Description = description;
        this.noOfStars = noOfStars;
        this.Admin = admin;
    }

    public Company (Company company){
        this.UEN = company.getUEN();
        this.name = company.getName();
        this.PhoneNo = company.getPhoneNo();
        this.street = company.getStreet();
        this.postalCode = company.getPostalCode();
        this.Description = company.getDescription();
        this.noOfStars = company.getNoOfStars();
        this.Admin = company.getAdmin();
    }

    //Parcelable constructor
    //Has to be the same order as the writeToParcel method**
    protected Company(Parcel in) {
        UEN = in.readInt();
        name = in.readString();
        PhoneNo = in.readInt();
        street = in.readString();
        postalCode = in.readInt();
        Description = in.readString();
        noOfStars = in.readInt();
    }

    //Create parcelables
    public static final Creator<Company> CREATOR = new Creator<Company>() {
        @Override
        public Company createFromParcel(Parcel in) {
            return new Company(in);
        }

        @Override
        public Company[] newArray(int size) {
            return new Company[size];
        }
    };

    public int getUEN() {
        return UEN;
    }

    public void setUEN(int UEN) {
        this.UEN = UEN;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public int getPhoneNo() {
        return PhoneNo;
    }

    public void setPhoneNo(int phoneNo) {
        PhoneNo = phoneNo;
    }

    public String getStreet() {
        return street;
    }

    public void setStreet(String street) {
        this.street = street;
    }

    public int getPostalCode() {
        return postalCode;
    }

    public void setPostalCode(int postalCode) {
        this.postalCode = postalCode;
    }

    public String getDescription() {
        return Description;
    }

    public void setDescription(String description) {
        Description = description;
    }

    public int getNoOfStars() {
        return noOfStars;
    }

    public void setNoOfStars(int noOfStars) {
        this.noOfStars = noOfStars;
    }

    public User getAdmin() {
        return Admin;
    }

    public void setAdmin (String name, String email, String password, Status status){
        this.Admin = new User(name, email, password, status, Role.companyAdmin);
    }

    @Override
    public String toString() {
        return "Company{" +
                "UEN=" + UEN +
                ", name='" + name + '\'' +
                ", PhoneNo=" + PhoneNo +
                ", street='" + street + '\'' +
                ", postalCode='" + postalCode + '\'' +
                ", Description='" + Description + '\'' +
                ", noOfStars='" + noOfStars + '\'' +
                ", Admin=" + Admin +
                '}';
    }

    @Override
    public int describeContents() {
        return 0;
    }

    //Parcelable adds class attributes into the parcel
    //Has to be the same order as the Parcelable constructor method**
    @Override
    public void writeToParcel(Parcel parcel, int i) {
        parcel.writeInt(UEN);
        parcel.writeString(name);
        parcel.writeInt(PhoneNo);
        parcel.writeString(street);
        parcel.writeInt(postalCode);
        parcel.writeString(Description);
        parcel.writeInt(noOfStars);
    }
}
