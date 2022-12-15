package com.example.fyphomeowner;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.NumberPicker;
import android.widget.PopupWindow;
import android.widget.Spinner;
import android.widget.Toast;

import java.util.ArrayList;

import kotlin.jvm.Volatile;


public class registerActivity extends AppCompatActivity {
    //Define variables
    private EditText usernameTxt;
    private EditText passwordTxt;           //need encrypt
    private EditText retypePasswordTxt;     //need validate against pwd
    private EditText emailTxt;
    private EditText streetTxt;
    private EditText blockNoTxt;
    private EditText unitNoTxt;
    private EditText postalCodeTxt;
    private EditText phoneNoTxt;
    private EditText nameTxt;
    private String houseTypeVal;
    private int householdSizeVal;
    private Spinner houseTypesSpinner;              //need to implement get the information
    private NumberPicker householdSizePicker;
    public static ArrayList<Homeowner> tempHomeownerDB;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);

        houseTypesSpinner = findViewById(R.id.houseTypesSpinner);
        householdSizePicker = findViewById(R.id.householdSizePicker);

        //RE-ENTER PASSWORD LISTENER        [prompts user for same re-enter password]
        //Define password edittext variables
        passwordTxt = findViewById(R.id.passwordTxt);
        retypePasswordTxt = findViewById(R.id.retypePasswordTxt);
        //Set onFocusChange listener on re-enter password prompt
        retypePasswordTxt.setOnFocusChangeListener(new View.OnFocusChangeListener(){
            @Override
            public void onFocusChange(View view, boolean bool){
                String pwd = passwordTxt.getText().toString();
                String repwd = retypePasswordTxt.getText().toString();

                if(!TextUtils.isEmpty(pwd) && !TextUtils.isEmpty(repwd)){
                    if(!bool){
                        //When re-enter password not in focus
                        verifyReEnterPassword(pwd, repwd);
                    }
                }
            }
        });

        //SPINNER
        //Array list for spinner
        ArrayList<HouseType> houseTypes = new ArrayList<>();
        for (HouseType ht : HouseType.values()){
            houseTypes.add(ht);
        }
        //Add the arraylist into the spinner
        ArrayAdapter<HouseType> houseTypesAdapter = new ArrayAdapter<HouseType>(this, android.R.layout.simple_spinner_dropdown_item, houseTypes);
        houseTypesSpinner.setAdapter(houseTypesAdapter);

        //NUMBER PICKER
        //Set min max for the number picker
        householdSizePicker.setMinValue(1);
        householdSizePicker.setMaxValue(10);
        //set what to when the number changes
        householdSizePicker.setOnValueChangedListener(new NumberPicker.OnValueChangeListener() {
            @Override
            public void onValueChange(NumberPicker numberPicker, int oldVal, int newVal) {
                //textView.setText(String.format("User's Number: %s", newVal))
            }
        });
    }

    public void onRegisterBtnClick(View view) {
        usernameTxt = findViewById(R.id.usernameTxt);
        passwordTxt = findViewById(R.id.passwordTxt);
        retypePasswordTxt = findViewById(R.id.retypePasswordTxt);
        emailTxt = findViewById(R.id.emailTxt);
        streetTxt = findViewById(R.id.streetTxt);
        blockNoTxt = findViewById(R.id.blockNoTxt);
        unitNoTxt = findViewById(R.id.unitNoTxt);
        postalCodeTxt = findViewById(R.id.postalCodeTxt);
        phoneNoTxt = findViewById(R.id.phoneNoTxt);
        nameTxt = findViewById(R.id.nameTxt);
        houseTypeVal = houseTypesSpinner.getSelectedItem().toString();
        householdSizeVal = householdSizePicker.getValue();

        ArrayList<EditText> inputs = new ArrayList<EditText>();
        inputs.add(usernameTxt);
        inputs.add(passwordTxt);
        inputs.add(retypePasswordTxt);
        inputs.add(emailTxt);
        inputs.add(streetTxt);
        inputs.add(blockNoTxt);
        inputs.add(unitNoTxt);
        inputs.add(postalCodeTxt);
        inputs.add(phoneNoTxt);
        inputs.add(nameTxt);

        if(verifyReEnterPassword(passwordTxt.getText().toString(), retypePasswordTxt.getText().toString())){
            if(checkNull(inputs)){
                //Toast.makeText(this, String.valueOf(householdSizeVal), Toast.LENGTH_SHORT).show();
                // Verify email
                // Add popup for email 2FA
                showPopupWindowClick(view);
                // Verify 2FA code
                // Success message, then link to login page
//                Homeowner homeowner = createAcc(nameTxt, emailTxt, passwordTxt, phoneNoTxt, streetTxt, blockNoTxt, unitNoTxt, postalCodeTxt, houseTypeVal, householdSizeVal);
//                tempHomeownerDB.add(homeowner);
            }
        }
    }

    public boolean checkNull(ArrayList<EditText> inputs){
        boolean bool = false;

        for(int i = 0; i < inputs.size(); i++){
            EditText currInput = inputs.get(i);

            if(!TextUtils.isEmpty(currInput.getText().toString())){
                bool = true;
            }
            else{
                Toast.makeText(this,"Empty field, please fill in.", Toast.LENGTH_SHORT).show();
                bool = false;
                break;
            }
        }
        return bool;
    }

    public boolean verifyReEnterPassword(String pwd, String repwd){
        boolean bool;

        if (!(pwd.equals(repwd))){
            Toast.makeText(getApplicationContext(),"please enter the same password", Toast.LENGTH_SHORT).show();
            bool = false;
        }
        else{
            bool = true;
        }
        return bool;
    }

    public Homeowner createAcc(EditText name, EditText email, EditText password, EditText phoneNoTxt, EditText street, EditText blkNo, EditText unitNo,
                               EditText postalCodeTxt, String houseTypeString, int householdSize){

        int phoneNo = Integer.parseInt(phoneNoTxt.getText().toString());
        int postalCode = Integer.parseInt(postalCodeTxt.getText().toString());
        Status status = Status.notValidated;
        Role type = Role.homeowner;
        Company subscribedCompany = null;
        HouseType houseType = HouseType.valueOf(houseTypeString);

        Homeowner homeowner = new Homeowner(name.getText().toString(), email.getText().toString(), password.getText().toString(), status, type,
                phoneNo, street.getText().toString(), blkNo.getText().toString(), unitNo.getText().toString(), postalCode, houseType, householdSize, subscribedCompany);

        return homeowner;
    }

    //Popup window method
    public void showPopupWindowClick(View view) {

        // inflate the layout of the popup window
        LayoutInflater inflater = (LayoutInflater)
                getSystemService(LAYOUT_INFLATER_SERVICE);
        View popupView = inflater.inflate(R.layout.popup_window, null);

        // create the popup window
        int width = LinearLayout.LayoutParams.WRAP_CONTENT;
        int height = LinearLayout.LayoutParams.WRAP_CONTENT;
        boolean focusable = true; // lets taps outside the popup also dismiss it
        final PopupWindow popupWindow = new PopupWindow(popupView, width, height, focusable);

        // show the popup window
        // which view you pass in doesn't matter, it is only used for the window token
        popupWindow.showAtLocation(view, Gravity.CENTER, 0, 0);

        // dismiss the popup window when touched
        popupView.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                popupWindow.dismiss();
                return true;
            }
        });

        popupWindow.setOnDismissListener(new PopupWindow.OnDismissListener(){
            @Override
            public void onDismiss(){
                openVerificationPage();
            }
        });
    }

    public void openLoginPage(){
        Intent intent = new Intent(this, loginActivity.class);
        startActivity(intent);
    }

    public void openVerificationPage(){
        Intent intent = new Intent(this, verificationActivity.class);
        startActivity(intent);
    }
}