import React from "react";

import { CustomButton } from "./style";

export const Button = ({ children, ...props }) => (
    <CustomButton {...props}>{children}</CustomButton>
);
