import React, { useState } from "react";
import { Button, Row, Col } from "reactstrap";
import axios from "axios";
import UserList from "./UsersListing";
import Swal from "sweetalert2";
import { AvForm, AvField } from "availity-reactstrap-validation";
import { error } from "jquery";

export default function CreateUser(props) {
    const [expense, setExpense] = useState({
        Username: "",
        email: "",
        phone: "",
        password: "",
        type: "1",
        address: "",
    });

  
    const handleChange = (e) => {
        const { name, value } = e.target;
        setExpense((expense) => ({
            ...expense,
            [name]: value,
        }));
    };

    const handleOnValid = (event, value) => {
        const expenseObject = {
            ...expense,
        };
        axios
            .post("http://localhost:8000/api/product/", expenseObject)
            .then((res) => {
                Swal.fire("Good job!", "Expense Added Successfully", "success")
                .then(() => {
                    window.location.reload(false);
                });   
            })
            .catch((error) => {
                Swal.fire({
                    title: "Error!",
                    text: "Do you want to continue ?",
                    icon: "error",
                    confirmButtonText: "Cool",
                });
            });
        
    };

    const handleOnInvalid = (event, error) => {
        Swal.fire({
            title: "Error!",
            text: "Do you want to continue ?",
            icon: "error",
            confirmButtonText: "Cool",
        });
    };

    return (
        <div className="form-wrapper">
            <AvForm
                onValidSubmit={handleOnValid}
                onInvalidSubmit={handleOnInvalid}
            >
                <Row>
                    <Col lg="6" md="6" sm="12">
                        <AvField
                            name="Username"
                            label="Username"
                            type="text"
                            placeholder="User Name..."
                            value={expense.Username}
                            onChange={handleChange}
                            validate={{
                                required: {
                                    value: true,
                                    errorMessage: "Please enter user name",
                                },
                            }}
                        />
                    </Col>
             
                </Row>
                <Row>
                <Col lg="6" md="6" sm="12">
                        <AvField
                            name="email"
                            label="Email"
                            type="text"
                            placeholder="Enter Email..."
                            value={expense.email}
                            onChange={handleChange}
                            validate={{
                                required: {
                                    value: true,
                                    errorMessage: "Please enter Email",
                                },
                            }}
                        />
                    </Col>
                    <Col lg="6" md="6" sm="12">
                        <AvField
                            name="phone"
                            label="Phone Number"
                            type="text"
                            placeholder="Enter Email..."
                            value={expense.phone}
                            onChange={handleChange}
                            validate={{
                                required: {
                                    value: true,
                                    errorMessage: "Please enter Phone Number",
                                },
                            }}
                        />
                    </Col>
                    <Col lg="6" md="6" sm="12">
                        <AvField
                            name="password"
                            label="Password"
                            type="text"
                            placeholder="Enter Password..."
                            value={expense.password}
                            onChange={handleChange}
                            validate={{
                                required: {
                                    value: true,
                                    errorMessage: "Please enter Password!!",
                                },
                            }}
                        />
                    </Col>
                    <Col lg="6" md="6" sm="12">
                        <AvField
                            name="type"
                            label="type"
                            type="select"
                            value={expense.type}
                            onChange={handleChange}
                        >
                            <option value="1">Admin</option>
                            <option value="2">User</option>
                            <option value="3">Other</option>
                        </AvField>
                    </Col>
                </Row>
                <Button
                    type="submit"
                    color="primary"
                    className="btn-md btn-block"
                >
                    SUBMIT
                </Button>
            </AvForm>
            <br></br>
            <br></br>
             <UserList></UserList>
         
        </div>
    );
}
