import React, { useState, useEffect } from "react";
import { Link, useHistory } from "react-router-dom";
import { Container, Table, Button } from "reactstrap";
import axios from "axios";
import "../../../css/CartList.css";

export default function CartTableRow() {
    // const [product_qty, setQuantity] = useState(1);
    const [cart, setUserCart] = useState([
        {
            product_id: 1,
            product_name: "Product 1",
            product_image:
                "https://www.mountaingoatsoftware.com/uploads/blog/2016-09-06-what-is-a-product.png",
            ptoduct_price: 12.25,
        },
    ]);

    useEffect(() => {
        // let isMounted=true;
        let tokenStr = localStorage.getItem("loginToken");
        //Pass tokenLogin at Authorization of headers
        const fetchData = async () => {
            const result = await axios(`http://localhost:8000/api/cart_user`, {
                headers: { Authorization: `Bearer ${tokenStr}` },
            });
        };
        fetchData();
    }, []);

    return (
        <div className="view_cart">
            <div className="my-5">
                <div className="cart">
                    <div className="cart-header text-center">
                        <h1>Shopping Cart</h1>
                    </div>
                    <Container fluid>
                        <div className="cart-body">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th></th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>
                                            <div
                                                className="product-item"
                                            >
                                                <a href="#" target="_blank">
                                                    <img
                                                        src={
                                                            cart[0]
                                                                .product_image
                                                        }
                                                        alt=""
                                                        className="img-fluid"
                                                    />
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div className="product-info">
                                                <a
                                                    href="./product-detail.html?productName=<?= $arrProduct['name']?>"
                                                    className="product-name"
                                                >
                                                    {" "}
                                                    {cart[0].product_name}{" "}
                                                </a>
                                                <br />
                                                <a
                                                    href="./cart-interaction.php?productName=R<?=$arrProduct['name']?>"
                                                    className="btn-remove"
                                                >
                                                    Remove
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div className="quantity">
                                                <a href="./cart-interaction.php?productName=M<?=$arrProduct['name']?>">
                                                    -
                                                </a>
                                                <span className="mx-2"> 12 </span>
                                                <a href="./cart-interaction.php?productName=P<?=$arrProduct['name']?>">
                                                    +
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div className="total">
                                                <p className="price">
                                                    {cart[0].ptoduct_price}
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </Container>
                </div>
            </div>
        </div>
    );
}
