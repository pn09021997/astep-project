import React, { useState, useEffect } from "react";
import { Button, Row, Col } from "reactstrap";
import axios from "axios";
import Swal from "sweetalert2";
import { AvForm, AvField } from "availity-reactstrap-validation";
import { Link } from "react-router-dom";
import "../../../../css/EditExpense.css";

export default function EditUser(props) {
    const [expense, setExpense] = useState({
        product_name: "",
        description: "",
        quantity: "",
        price: "",
        category_id: "",
        product_image: "",
    });

    useEffect(() => {
        const fetchData = async () => {
            const result = await axios.get(
                "http://localhost:8000/api/user/" + props.match.params.id
            );
            const { data } = await result;
            setExpense(data);
        };
        fetchData();
    }, []);

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

        Swal.fire({
            title: "Do you want to save the changes?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Save",
            denyButtonText: `Don't save`,
        }).then((result) => {
            if (result.isConfirmed) {
                axios
                    .patch(
                        "http://localhost:8000/api/user/" +
                            props.match.params.id,
                        expenseObject
                    )
                    .catch((error) => {
                        Swal.fire({
                            title: "Error!",
                            text: "Do you want to continue ?",
                            icon: "error",
                            confirmButtonText: "Cool",
                        });
                    });

                Swal.fire("Saved!", "", "success")
                .then(() => {
                    props.history.push(`/edit-expense/${props.match.params.id}`);
                });
            } else if (result.isDenied) {
                Swal.fire("Changes are not saved", "", "info")
            }
        });
    };

    const handleOnInvalid = (event, error, value) => {
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
                    color="danger"
                    className="btn-md btn-block mb-2"
                >
                    UPDATE
                </Button>
                <Link to="/">
                    <Button
                        color="danger"
                        outline
                        className="btn-md btn-block mb-2"
                    >
                        BACK
                    </Button>
                </Link>
            </AvForm>
        </div>
    );
}
