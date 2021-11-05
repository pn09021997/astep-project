import React, { useState } from "react";
import { Form, FormGroup, Input, Label, Button, Row, Col } from 'reactstrap';
import axios from "axios";
import ExpensesList from "./ExpensesListing";
import Swal from "sweetalert2";

export default function CreateExpense(props) {
    const [expense, setExpense] = useState({
        name: "",
        description: "",
        amount: "",
    });

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
            .post("http://localhost:8000/api/product/", expenseObject)
            .then((res) => console.log(res.data));
        Swal.fire("Good job!", "Expense Added Successfully", "success");

        setExpense({ name: '', amount: '',description: ''  });
    };

    return (
        <div className="form-wrapper">
            <Form onSubmit={doSubmit}>
                <Row>
                    <Col>
                        <FormGroup controlid="name">
                            <Label>Name</Label>
                            <Input
                                name="name"
                                type="text"
                                value={expense.name}
                                onChange={handleChange}
                            />
                        </FormGroup>
                    </Col>

                    <Col>
                        <FormGroup controlid="amount">
                            <Label>Amount</Label>
                            <Input
                                name="amount"
                                type="number"
                                value={expense.amount}
                                onChange={handleChange}
                            />
                        </FormGroup>
                    </Col>
                </Row>

                <FormGroup controlid="description">
                    <Label>Description</Label>
                    <Input
                        name="description"
                        as="textarea"
                        type="textarea"
                        value={expense.description}
                        onChange={handleChange}
                    />
                </FormGroup>

                <Button variant="primary" size="lg" block="block" type="submit">
                    Add Expense
                </Button>
            </Form>
            <br></br>
            <br></br>

            <ExpensesList> </ExpensesList>
        </div>
    );
}
