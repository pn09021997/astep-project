import React from "react";
import ProductManager from "./ProductManager/ProductManager";
import UserManager from "./UserManager/UserManager";
// import CreateUser from "./UserManager/CreateUser";


export default function Admin() {
    return (
        <div className="admin">
            <UserManager/>
        </div>
    );
}
