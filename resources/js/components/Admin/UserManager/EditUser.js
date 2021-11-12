import React, { useState, useEffect } from "react";
import { Button, Row, Col } from "reactstrap";
import axios from "axios";
import Swal from "sweetalert2";
import { AvForm, AvField } from "availity-reactstrap-validation";
import { Link } from "react-router-dom";
import "../../../../css/EditExpense.css";

export default function EditUser(props) {
    const [expense, setExpense] = useState({
        Username: "",
        email: "",
        phone: "",
        password: "",
        type: "",
        address: "",
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
                {/* hidden fields old_email */}
                 <AvField
                    name="old_email"
                    type="hidden"
                    // value={expense.old_email}
                    onChange={handleChange}
                    validate={{
                        required: {
                            value: true,
                        },
                    }}
                />
                {/* hidden old_phone */}
                 <AvField
                    name="old_phone"
                    type="hidden"
                 
                    value={expense.old_phone}
                    onChange={handleChange}
                    validate={{
                        required: {
                            value: true,
                        },
                    }}
                />
                {/* hidden old_address */}
                 <AvField
                    name="old_address"
                    type="hidden"
                    // value={expense.old_address}
                    onChange={handleChange}
                    validate={{
                        required: {
                            value: true,
                        },
                    }}
                />
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
                <AvField
                    name="email"
                    label="email"
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
                <AvField
                    name="phone"
                    label="Phone Number"
                    type="text"
                    placeholder="Enter Phone Number..."
                    value={expense.phone}
                    onChange={handleChange}
                    validate={{
                        required: {
                            value: true,
                            errorMessage: "Please enter Phone Number",
                        },
                    }}
                />
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
                <AvField
                    name="address"
                    label="address"
                    type="text"
                    placeholder="Enter addressr..."
                    value={expense.phone}
                    onChange={handleChange}
                    validate={{
                        required: {
                            value: true,
                            errorMessage: "Please enter address",
                        },
                    }}
                />
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
