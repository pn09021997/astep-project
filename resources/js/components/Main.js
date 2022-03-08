import React, { useState, useEffect } from "react";
import {
    Collapse,
    Navbar,
    NavbarToggler,
    NavbarBrand,
    Nav,
    NavItem,
    Alert,
} from "reactstrap";
import { BrowserRouter, Switch, Route, Link, Redirect } from "react-router-dom";
import "../../css/Main.css";

//Components
import Home from "./Home/Home";
import Login from "./Login/Login";
import Register from "./Login/Register";
import Detail from "./Detail/Detail";
import CartManager from "./CartPage/CartManager";
import CategoriesPage from "./CategoriesPage/CategoriesPage";
import NoMatch from "./NoMatch/NoMatch";
import axios from "axios";
export default function Main({ role, setRoleChange, setRoleOfUser }) {
    const [infoUser, setInfoUser] = useState({
        email: "",
        phone: "",
        address: "",
    });
    //Local Info Login User
    const [isLogin, setIsLogin] = useState({
        isLoginStatus: false,
    });

    //State of navbar
    const [collapsed, setCollapsed] = useState(true);
    const toggleNavbar = () => setCollapsed(!collapsed);
    const [keyword, setKeyword] = useState("none");
    const [searchResult, setSearchResult] = useState([]);
    const handleChangeKeyword = (e) => {
        const { name, value } = e.target;
        setKeyword(value);
    };

    /*useEffect(() => {
        const fetchData = async () => {
            const result = await axios(
                `http://localhost:8000/api/searchProduct/${keyword}`
            );
            setSearchResult(result.data.item);
        };
        fetchData();
    }, [keyword]);*/

    return (
        <div className="main">
            <BrowserRouter>
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
                    {/* search bar */}

                    <div className="search-box">
                        <form className="form-inline my-2 my-lg-0">
                            <input
                                className="form-control mr-sm-2"
                                name="keyword"
                                type="text"
                                placeholder="Search"
                                value={keyword}
                                onChange={handleChangeKeyword}
                            />
                            <button
                                className="btn mr-4 my-sm-0"
                                id="btnSearch"
                                type="submit"
                            >
                                Search
                            </button>
                        </form>
                    </div>
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
                                        ? infoUser.email
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
                <Switch>
                    <Route exact path="/">
                        <Home key="home" />
                    </Route>
                    <Redirect
                        from="/verify"
                        to="/login"
                    />
                    <Route path="/login">
                        <Login
                            key="login"
                            setInfoUser={setInfoUser}
                            setIsLogin={setIsLogin}
                            isLogin={isLogin}
                            role={role}
                            setRoleChange={setRoleChange}
                            setRoleOfUser={setRoleOfUser}
                        />
                    </Route>
                    <Route path="/register">
                        <Register key="register" />
                    </Route>
                    <Redirect
                        from="/product-detail/:product_id/reload"
                        to="/product-detail/:product_id"
                    />
                    <Route path="/product-detail/:product_id">
                        <Detail key="product-detail" />
                    </Route>

                    <Route path="/cart">
                        <CartManager key="cart" />
                    </Route>
                    <Route path="/categories/:category_id">
                        <CategoriesPage key="categories-page" />
                    </Route>
                    <Route path="*">
                        <NoMatch />
                    </Route>
                </Switch>
            </BrowserRouter>
        </div>
    );
}
