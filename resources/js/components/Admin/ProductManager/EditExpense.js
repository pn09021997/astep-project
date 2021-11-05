import React, { useState, useEffect } from "react";
import { Form, FormGroup, Input, Label, Button, Row, Col } from 'reactstrap';
import axios from "axios";
import Swal from "sweetalert2";

export default function EditExpense(props) {
    const [expense, setExpense] = useState({
        name: "",
        amount: "",
        description: "",
    });

    useEffect(() => {
        axios
            .get("http://localhost:8000/api/product/" + props.match.params.id)
            .then((res) => {
                setExpense({
                    name: res.data.name,
                    amount: res.data.amount,
                    description: res.data.description,
                });
            })
            .catch((error) => {
                console.log(error);
            });
    }, []);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setExpense((expense) => ({
            ...expense,
            [name]: value,
        }));
    };

    const doSubmit = (e) => {
        e.preventDefault();

        const expenseObject = {
            name: expense.name,
            amount: expense.amount,
            description: expense.description,
        };

        axios
            .patch(
                "http://localhost:8000/api/product/" + props.match.params.id,
                expenseObject
            )
            .then((res) => {
                console.log(res.data);
                Swal.fire("Good job!", "Expense Updated Successfully", "success");
            })
            .catch((error) => {
                console.log(error);
            });

        // Redirect to Expense List
        props.history.push("/edit-expense/" + props.match.params.id);
    };

    return (
        <div className="form-wrapper">
            <Form onSubmit={doSubmit}>
                <FormGroup controlid="Name">
                    <Label>Name</Label>
                    <Input
                        name="name"
                        type="text"
                        value={expense.name}
                        onChange={handleChange}
                    />
                </FormGroup>

                <FormGroup controlid="Amount">
                    <Label>Amount</Label>
                    <Input
                        name="amount"
                        type="number"
                        value={expense.amount}
                        onChange={handleChange}
                    />
                </FormGroup>

                <FormGroup controlid="Description">
                    <Label>Description</Label>
                    <Input
                        name="description"
                        type="text"
                        value={expense.description}
                        onChange={handleChange}
                    />
                </FormGroup>

                <Button variant="danger" size="lg" block="block" type="submit">
                    Update Expense
                </Button>
            </Form>
        </div>
    );
}
