import React, { useState } from "react";
import { Link, useHistory } from "react-router-dom";
import { Button, Container } from "reactstrap";
import { Modal, Form, Row, Col, FloatingLabel } from 'react-bootstrap';
import axios from "axios";
import Swal from "sweetalert2";

export default function CartTableRow() {
    const [show, setShow] = useState(false);

    const handleClose = () => setShow(false);
    const handleShow = () => setShow(true);
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
            <Container>
                <tr>
                    <td></td>
                    {/* <td>{props.obj.product}</td> */}
                    <img src="https://cdn.shopify.com/s/files/1/0076/1708/5530/products/1-5_240x240.jpg?v=1609296589" alt="BN0032 - Steel" width="100px" />
                    <td className="product_tittle">
                        <a href="/products/soundless-speaker?variant=39273609429082" class="h6">
                            Soundless Speaker
                        </a>
                        <Button
                            // onClick={deleteCart}
                            className="btn-sm btn-block"
                            color="danger"> Remove
                        </Button>
                    </td>
                    <td className="quantity_cart">
                        <input type="number" value="1" className="text ng-pristine ng-untouched ng-valid" />
                    </td>
                    {/* {props.obj.quantity}</td> */}
                    <td className="cart_total">
                        {/* $ {props.obj.Total} */}
                        $200
                    </td>
                </tr>
                <div className="Checlout_cart col text-center text-md-right">
                    <p class="h3 cart__subtotal"><span class="money">$398.00</span></p>
                    <button onClick={handleShow} type="submit" class="btn btn-theme gradient-theme btn-cart-checkout">Check Out</button>
                </div>
                <Modal
                    show={show}
                    onHide={handleClose}
                    backdrop="static"
                    keyboard={false}
                >
                    <Modal.Header closeButton>
                        <Modal.Title>Thông tin địa chỉ</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <Row>
<<<<<<< HEAD
                            <AvForm className="form_input">
                                <AvField
                                    hidden
                                    name="Address"
                                    type="text"
                                />
                                <AvField
                                    name="Address"
                                    label="Address"
                                    type="text"
                                    placeholder="Address here..."
                                    validate={{
                                        required: {
                                            value: true,
                                            errorMessage: "Please enter your Address",
                                        },
                                        email: {
                                            value: true,
                                            errorMessage: "Your Address not correct",
                                        },
                                    }}
                                />
                                <AvField
                                    hidden
                                    name="note"
                                    type="text"
                                />
                                <AvField
                                    name="note"
                                    label="note"
                                    placeholder="note here..."
                                    type="textarea"
                                    validate={{
                                        required: {
                                            value: true,
                                            errorMessage: "Please enter your notes",
                                        },
                                        email: {
                                            value: true,
                                            errorMessage: "Your Address not note",
                                        },
                                    }}
                                />
                               
                            </AvForm>
=======
                            <Col md>
                                <Form.Control type="email" placeholder="Address buy" />
                            </Col>
                            <Col md>
                            <Form.Control type="email" placeholder="note product cart" />
                            </Col>
>>>>>>> bbbf9589361f26d0d7c45596f392335a98a77e02
                        </Row>
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="secondary" onClick={handleClose}>
                            Close
                        </Button>
                        <Button variant="primary">Understood</Button>
                    </Modal.Footer>
                </Modal>
            </Container>
        </div>
    );
}
