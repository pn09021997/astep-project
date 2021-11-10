import React, { useState } from "react";
import { AvForm, AvField } from "availity-reactstrap-validation";
import { Button } from "reactstrap";
import { Link, useHistory } from "react-router-dom";
import Swal from "sweetalert2";
import "../../../css/Info.css";
import { update } from "lodash";
export default function Info({ isLogin }) {
    const history = useHistory();
    const [updateData, setUpdateData] = useState({
        email: isLogin.email,
        phone: isLogin.phone,
        address: isLogin.address,
        fieldChange: [],
    });
    //Check change of input
    const [preInfoLogin, setPreInfoLogin] = useState({ ...isLogin });
    //Catch onChange on input of update form to save in state infoLogin
    const handleChange = (e) => {
        const { name, value } = e.target;
        setUpdateData((updateData) => ({
            ...updateData,
            [name]: value,
            fieldChange:
                updateData.fieldChange.indexOf(name) === -1
                    ? [...updateData.fieldChange, name]
                    : [...updateData.fieldChange],
        }));
        console.table(updateData.fieldChange);
    };

    const doUpdateInfo = (event, values) => {
        console.log(`Successfully`);
        history.push("/");
    };
    const handleInvalidSubmit = (event, errors, values) => {
        Swal.fire({
            title: "Error!",
            text: "Do you want to continue ?",
            icon: "error",
            confirmButtonText: "Cool",
        });
    };
    return (
        <div className="info container mt-5 mb-5">
            <h1 className="info-title text-center">WELCOME BACK</h1>
            <AvForm
                onValidSubmit={doUpdateInfo}
                onInvalidSubmit={handleInvalidSubmit}
            >
                <AvField
                    name="email"
                    label="Email"
                    type="text"
                    placeholder="Email here..."
                    value={updateData.email}
                    onChange={handleChange}
                    validate={{
                        required: {
                            value: true,
                            errorMessage: "Please enter your email",
                        },
                        email: {
                            value: true,
                            errorMessage: "Your email not correct",
                        },
                    }}
                />
                <AvField
                    name="phone"
                    label="Phone"
                    placeholder="Phone here..."
                    type="tel"
                    value={updateData.phone}
                    onChange={handleChange}
                    validate={{
                        required: {
                            value: true,
                            errorMessage: "Please enter your phone",
                        },
                        minLength: {
                            value: 10,
                            errorMessage: "Your phone must be 10 numbers",
                        },
                        maxLength: {
                            value: 10,
                            errorMessage: "Your phone must be 10 numbers",
                        },
                    }}
                />
                <AvField
                    name="address"
                    label="Address"
                    placeholder="Address here..."
                    type="textarea"
                    value={updateData.address}
                    onChange={handleChange}
                    validate={{
                        required: {
                            value: true,
                            errorMessage: "Please enter your address",
                        },
                    }}
                />
                <Button
                    type="submit"
                    color="secondary"
                    className="btn-md btn-block"
                >
                    Update
                </Button>
                <Link to="/">
                    <Button
                        color="outline-secondary"
                        className="btn-md btn-block mt-2"
                        id="btnBack"
                    >
                        Back to Home
                    </Button>
                </Link>
            </AvForm>
        </div>
    );
}
