import React, { useState } from "react";

import { Container, CustomCard, FormControl } from "./style";
import { Button } from "../button";
import { Form } from "../form";

const Login = () => {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");

    const onSubmit = e => {
        e.preventDefault();
        console.log("Clicked");
    };

    return (
        <Container>
            <CustomCard>
                <Form onSubmit={onSubmit}>
                    <h1>LOGIN</h1>
                    <FormControl>
                        <input
                            type="email"
                            name="email"
                            value={email}
                            required
                            placeholder="Email Address"
                            onChange={e => setEmail(e.target.value)}
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

                    <Button>Login</Button>
                </Form>
            </CustomCard>
        </Container>
    );
};

export default Login;
