import React, { useState } from "react";

import {
    Container,
    CustomCard,
    FormControl,
    FormUsername,
    CheckBoxContainer,
    CustomLink
} from "./style";
import { Button } from "../button";
import { Form } from "../form";

const Register = () => {
    const [first_name, setFirstname] = useState("");
    const [last_name, setLastname] = useState("");
    const [email, setEmail] = useState("");
    const [phone, setPhone] = useState("");
    const [password, setPassword] = useState("");
    const [confirmpassword, setConfirmPassword] = useState("");

    const onSubmit = e => {
        e.preventDefault();
    };

    return (
        <Container>
            <CustomCard>
                <Form onSubmit={onSubmit}>
                    <h1>REGISTER</h1>
                    <FormUsername>
                        <FormControl>
                            <input
                                type="text"
                                name="first_name"
                                value={first_name}
                                placeholder="First Name"
                                required
                                onChange={e => setFirstname(e.target.value)}
                            />
                        </FormControl>
                        <FormControl>
                            <input
                                type="text"
                                name="last_name"
                                value={last_name}
                                placeholder="Last Name"
                                required
                                onChange={e => setLastname(e.target.value)}
                            />
                        </FormControl>
                    </FormUsername>

                    <FormControl>
                        <input
                            type="email"
                            name="email"
                            value={email}
                            placeholder="Email Address"
                            required
                            onChange={e => setEmail(e.target.value)}
                        />
                    </FormControl>

                    <FormControl>
                        <input
                            type="number"
                            name="phone"
                            value={phone}
                            placeholder="Phone Number"
                            required
                            onChange={e => setPhone(e.target.value)}
                        />
                    </FormControl>

                    <FormControl>
                        <input
                            type="password"
                            name="password"
                            value={password}
                            placeholder="Password"
                            required
                            minLength="6"
                            onChange={e => setPassword(e.target.value)}
                        />
                    </FormControl>

                    <FormControl>
                        <input
                            type="password"
                            name="confirmpassword"
                            value={confirmpassword}
                            placeholder="Confirm Password"
                            required
                            minLength="6"
                            onChange={e => setConfirmPassword(e.target.value)}
                        />
                    </FormControl>

                    <CheckBoxContainer>
                        <div>
                            <label>
                                <input
                                    type="checkbox"
                                    className="filled-in"
                                    required
                                />
                                <span>
                                    Please agree to
                                    <CustomLink to="/termsandconditions">
                                        {" "}
                                        terms
                                    </CustomLink>{" "}
                                    to register
                                </span>
                            </label>
                        </div>
                    </CheckBoxContainer>

                    <Button>Register</Button>
                </Form>
            </CustomCard>
        </Container>
    );
};

export default Register;
