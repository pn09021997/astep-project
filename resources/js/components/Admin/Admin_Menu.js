import React from "react";
import {
    BrowserRouter as Router,
    Switch,
    Route,
    useLocation,
    Link,
} from "react-router-dom";
import { Col, Nav, NavItem, NavLink, Row } from "reactstrap";
import "../../../css/Admin_Menu.css";

import ProductManager from "./ProductManager/ProductManager";
import UserManager from "./UserManager/UserManager";
export default function Admin_Menu() {
    return (
        <div className="admin-menu">
            <Router>
                <Row>
                    <Col lg="2">
                        <div className="nav--custom">
                            <img
                                src="https://cdn.shopify.com/s/files/1/0076/1708/5530/files/logo_360x.png?v=1609091045"
                                alt="logo"
                                className="img-fluid logo--custom"
                            />
                            <Nav vertical pills>
                                <NavItem>
                                    <Link
                                        to="/create-expense"
                                        className="link--custom"
                                    >
                                        Product Manager
                                    </Link>
                                </NavItem>
                                <NavItem>
                                    <Link
                                        to="/categories-manager"
                                        className="link--custom"
                                    >
                                        Categories Manager
                                    </Link>
                                </NavItem>
                                <NavItem>
                                    <Link
                                        to="/create-user"
                                        className="link--custom"
                                    >
                                        User Manager
                                    </Link>
                                </NavItem>
                            </Nav>
                        </div>
                    </Col>
                    <Col lg="10">
                        <Switch>
                            <Route
                                path="/create-expense"
                                component={ProductManager}
                            />
                            <Route path="/categories-manager">
                                <CategoriesManager key="categories-manager" />
                            </Route>
                            <Route
                                  path="/create-user"
                                 component={UserManager}
                                 />
                            <Route path="*">
                                <NoMatch />
                            </Route>
                        </Switch>
                    </Col>
                </Row>
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

function CategoriesManager() {
    return (
        <div className="text-center">
            <h1> Categories Manager</h1>
        </div>
    );
}

