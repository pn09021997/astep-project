import React, { useState, useEffect } from "react";
import axios from "axios";
import { Table,Container } from 'reactstrap';
// import CartTableRow from "./CartTableRow";
import "../../../css/CartList.css";

export default function CartList() {
    // const [cart, setCart] = useState([]);

    // useEffect(() => {
    //     const fetchData = async () => {
    //         const result = await axios("http://localhost:8000/api/cart_user/");
    //         setCart(result.data);
    //     };
    //     fetchData();
    // }, []);

    // const DataTable = cart.map((res, i) => {
    //     return <CartTableRow obj={res} key={i} />;
    // });

    return (
        <div className="cart-page">
            <div className="page-width">
                <h2 className="text-center h3 mb-5">Shopping Cart</h2>
            </div>
            <Container>
                <div className="table-wrapper">
                    <Table striped hover>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th className="quantity_tittle">Quantity</th>
                                <th className="total_tittle">total</th>
                            </tr>
                        </thead>
                        {/* <tbody>{DataTable}</tbody> */}
                    </Table>
                </div>
            </Container>


        </div>

    );
}
