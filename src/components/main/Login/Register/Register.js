import React from "react";
import { Button, Form, FormGroup, Label, Input, FormText } from "reactstrap";
import { Link } from "react-router-dom";
import "./Register.css";

export default function Register({ accountData, setAccountData }) {
  //Do Register
  const setRegisterInfo = (registerCheck) => {
    if (registerCheck.length === 0) alert("Register Fail !!!");
    else {
      setAccountData([
        ...accountData,
        {
          id: accountData[accountData.length - 1].id + 1,
          ...registerCheck[0],
        },
      ]);
      alert("Register Success !!!");
      document.getElementById("btnBack").click();
    }
  };

  //Get Data at Form
  const doRegister = (e) => {
    e.preventDefault();
    let email = e.target.email.value;
    let password = e.target.password.value;
    let confirmPassword = e.target.confirmPassword.value;
    let birthday = e.target.birthday.value;
    let phone = e.target.phone.value;
    let fullname = e.target.fullname.value;

    let infoRegister = [
      {
        username: email,
        password: password,
        confirmPassword: confirmPassword,
        fullname: fullname,
        birthday: birthday,
        phone: phone,
      },
    ];

    let registerCheck = infoRegister.filter((value, index) => {
      return validateForm(value, accountData) === true;
    });
    setRegisterInfo(registerCheck);
  };

  //Check Register Info
  const validateForm = (infoRegister) => {
    let flag = true;
    infoRegister.password === infoRegister.confirmPassword
      ? (flag = true)
      : (flag = false);
    return flag;
  };

  return (
    <div className="register container">
      <h1 className="register-title text-center">REGISTER</h1>
      <Form method="GET" onSubmit={doRegister}>
        <FormGroup className="mb-3">
          <Label for="exampleEmail">Email</Label>
          <Input
            type="email"
            name="email"
            id="exampleEmail"
            placeholder="Email"
            valid
          />
          <FormText>We'll never share your email with anyone else.</FormText>
        </FormGroup>
        <FormGroup className="mb-3">
          <Label for="examplePassword">Password</Label>
          <Input
            type="password"
            name="password"
            id="examplePassword"
            placeholder="Password"
            invalid
          />
          <FormText>Must be 8-20 characters long.</FormText>
        </FormGroup>
        <FormGroup className="mb-3">
          <Label for="exampleConfirmPassword">Confirm Password</Label>
          <Input
            type="password"
            name="confirmPassword"
            id="exampleConfirmPassword"
            placeholder="Confirm Password"
          />
          <FormText>Must be 8-20 characters long.</FormText>
        </FormGroup>
        <FormGroup className="mb-3">
          <Label for="exampleFullname">Fullname</Label>
          <Input
            type="text"
            name="fullname"
            id="exampleFullname"
            placeholder="Fullname"
          />
          <FormText>Must not be over 100 characters long.</FormText>
        </FormGroup>
        <FormGroup className="mb-3">
          <Label for="exampleBirthday">Birthday</Label>
          <Input type="date" name="birthday" id="exampleBirthday" />
        </FormGroup>
        <FormGroup className="mb-3">
          <Label for="examplePhone">Phone</Label>
          <Input
            type="number"
            name="phone"
            id="examplePhone"
            placeholder="Phone"
          />
          <FormText>Must be 10 characters long.</FormText>
        </FormGroup>
        <FormGroup className="mb-3">
          <Button type="submit" color="info" className="main--custom-btn mb-2">
            Register
          </Button>
          <Link
            to="/login"
            id="btnBack"
          >
            <Button color="outline-info" className="main--custom-btn">
              Back to Login
            </Button>
          </Link>
        </FormGroup>
      </Form>
    </div>
  );
}
