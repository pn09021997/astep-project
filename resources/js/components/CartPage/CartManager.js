import React from "react";
import CartList from "./CartList";
import CartTableRow from "./CartTableRow";

export default function CartManager() {
    return (
        <div className="cart_manager">
            <CartList/>
            <CartTableRow/>
        </div>
    );
}
