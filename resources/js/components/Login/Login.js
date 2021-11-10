import React from "react";
import { Button, Form, FormGroup, Label, Input, FormText } from "reactstrap";
import { Link } from "react-router-dom";
import "../../../css/Login.css";
//Components
import Info from "./Info";

export default function Login({ isLogin, setIsLogin, accountData }) {
  //Do Login
  const setLoginInfo = (loginCheck) => {
    if (loginCheck.length === 0) alert("Login Fail !!!");
    else
      setIsLogin({
        ...loginCheck[0],
        isLoginStatus: true,
      });
  };

  //Get Data at Form
  const doLogin = (e) => {
    e.preventDefault();
    let email = e.target.email.value;
    let password = e.target.password.value;
    let infoLogin = {
      username: email,
      password: password,
    };

    let loginCheck = accountData.filter((value, index) => {
      return validateForm(infoLogin, value) === true;
    });
    setLoginInfo(loginCheck);
  };

  //Check Login Info at Form
  const validateForm = (infoLogin, accountData) => {
    let flag = true;
    infoLogin.username === accountData.username &&
    infoLogin.password === accountData.password
      ? (flag = true)
      : (flag = false);

    return flag;
  };

  //If isLogin -> Info, !isLogin -> Login
  if (isLogin.isLoginStatus) {
    return <Info isLogin={isLogin} accountData={accountData} />;
  } else {
    return (
      <div className="login container mt-5 mb-5">
        <h1 className="login-title text-center">LOGIN</h1>
        <Form method="GET" onSubmit={doLogin}>
          <FormGroup className="mb-3">
            <Label for="exampleEmail">Email</Label>
            <Input
              type="email"
              name="email"
              id="exampleEmail"
              placeholder="Email"
            />
            <FormText>Must be 8-20 characters long.</FormText>
          </FormGroup>
          <FormGroup className="mb-3">
            <Label for="examplePassword">Password</Label>
            <Input
              type="password"
              name="password"
              id="examplePassword"
              placeholder="Password"
            />
            <FormText>Must be 8-20 characters long.</FormText>
          </FormGroup>
          <FormGroup className="mb-3">
            <Button color="secondary" className="main--custom-btn mb-2">
              Login
            </Button>
            <Link
              to="/register"
              id="btnBack"
            >
              <Button color="outline-secondary" className="main--custom-btn">
                Register
              </Button>
            </Link>
          </FormGroup>
        </Form>
      </div>
    );
  }
}
