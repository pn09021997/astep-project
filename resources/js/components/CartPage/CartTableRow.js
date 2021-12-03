import React from "react";
import { Link, useHistory } from "react-router-dom";
import { Button } from "reactstrap";
import axios from "axios";
import Swal from "sweetalert2";

export default function CartTableRow() {
    // const history = useHistory();

    // const deleteCart = () => {
    //     Swal.fire({
    //         title: "Are you sure?",
    //         text: "You won't be able to revert this!",
    //         icon: "warning",
    //         showCancelButton: true,
    //         confirmButtonColor: "#3085d6",
    //         cancelButtonColor: "#d33",
    //         confirmButtonText: "Yes, delete it!",
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             axios
    //                 .delete("http://localhost:8000/api/cart_user/" + props.obj.id)
    //                 .then((res) => {
    //                     Swal.fire(
    //                         "Good job!",
    //                         "Cart Delete Successfully",
    //                         "success"
    //                     ).then(() => {
    //                         history.push("/cart");
    //                     })
    //                 })
    //                 .catch((error) => {
    //                     console.log(error);
    //                 });
    //         }
    //     });

   
    return (
        <div className="view_cart">
            <tr>
                <td></td>
                {/* <td>{props.obj.product}</td> */}
                <td>
                    <Button
                        // onClick={deleteCart}
                        className="btn-sm btn-block"
                        color="danger">
                    </Button>
                </td>
                <td className="quantity">
                    <input type="number" value="1" className="text ng-pristine ng-untouched ng-valid" />
                </td>
                {/* {props.obj.quantity}</td> */}
                {/* <td>$ {props.obj.Total}</td> */}
            </tr>
            <div className="Checlout_cart col text-center text-md-right">
                <p class="h3 cart__subtotal"><span class="money">$398.00</span></p>
                <button type="submit" class="btn btn-theme gradient-theme btn-cart-checkout">Check Out</button>
            </div>
        </div>
    );
}
