import React, { useEffect, useState } from "react";
import { Alert } from "reactstrap";
import CartTableRow from "./CartTableRow";

export default function CartManager() {
    if (localStorage.getItem("loginToken")) {
        return (
            <div className="cart_manager">
                <CartTableRow />
            </div>
        );
    } else {
        return <Alert color="primary" style={{ fontSize: "1.1rem", textAlign: "center" }}>
            Please Login first !!!
        </Alert>
    }

}
