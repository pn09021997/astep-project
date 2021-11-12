import React, { useState, useEffect } from "react";
import {
    Collapse,
    Navbar,
    NavbarToggler,
    NavbarBrand,
    Nav,
    NavItem,
} from "reactstrap";
import {
    BrowserRouter as Router,
    Switch,
    Route,
    Link,
    useLocation,
} from "react-router-dom";
import "../../css/Main.css";

//Components
import Home from "./Home/Home";
import Login from "./Login/Login";
import Register from "./Login/Register";

export default function Main() {
    //Account Data
    const [accountData, setAccountData] = useState([
        {
            id: 0,
            username: "pn0921997",
            password: "1234567",
            email: "pn0921997@gmail.com",
            address: "TDC",
            phone: "0123456789",
            address: "TDC"
        },
        {
            id: 1,
            username: "vyvy09021997",
            password: "1234567",
            email: "vyvy09021997@gmail.com",
            address: "TDC",
            phone: "9876543210",
        },
    ]);

    //Local Info Login User
    const [isLogin, setIsLogin] = useState({
        id: "none",
        username: "none",
        password: "none",
        email: "none",
        address: "none",
        phone: "none",
        isLoginStatus: false,
    });

    //State of navbar
    const [collapsed, setCollapsed] = useState(true);
    const toggleNavbar = () => setCollapsed(!collapsed);

    return (
        <div className="main">
            <Router>
                <Navbar
                    color="dark"
                    dark
                    key="navbar"
                    className="main-navbar container-fluid"
                >
                    <NavbarBrand href="/" className="mr-auto">
                        <img
                            src="https://cdn.shopify.com/s/files/1/0076/1708/5530/files/logo_white_360x.png?v=1612539402"
                            alt="uneox logo"
                            className="img-fluid navbar--custom-logo"
                        />
                    </NavbarBrand>
                    <NavbarToggler onClick={toggleNavbar} className="mr-2" />
                    <Collapse isOpen={!collapsed} navbar>
                        <Nav navbar>
                            <NavItem className="mb-3">
                                <Link
                                    to="/"
                                    className="main-navbar--custom-link"
                                >
                                    Home
                                </Link>
                            </NavItem>
                            <NavItem className="mb-3">
                                <Link
                                    to="/login"
                                    className="main-navbar--custom-link"
                                >
                                    {isLogin.isLoginStatus
                                        ? isLogin.username
                                        : "Login"}
                                </Link>
                            </NavItem>
                            <NavItem className="mb-3">
                                <Link
                                    to="/register"
                                    className="main-navbar--custom-link"
                                >
                                    Register
                                </Link>
                            </NavItem>
                        </Nav>
                    </Collapse>
                </Navbar>

                {/* A <Switch> looks through its children <Route>s and
            renders the first one that matches the current URL. */}
                <Switch>
                    <Route path="/login">
                        <Login
                            key="login"
                            accountData={accountData}
                            setIsLogin={setIsLogin}
                            isLogin={isLogin}
                        />
                    </Route>
                    <Route path="/register">
                        <Register
                            key="register"
                            accountData={accountData}
                            setAccountData={setAccountData}
                        />
                    </Route>
                    <Route path="/">
                        <Home key="home" />
                    </Route>
                    <Route path="*">
                        <NoMatch />
                    </Route>
                </Switch>
            </Router>
        </div>
    );
}

function NoMatch() {
    let location = useLocation();

    return (
        <div>
            <h3>
                No match for <code>{location.pathname}</code>
            </h3>
        </div>
    );
}
