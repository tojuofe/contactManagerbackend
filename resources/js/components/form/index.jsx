import React from "react";

import { CustomForm } from "./style";

export const Form = ({ onSubmit, children }) => (
    <CustomForm onSubmit={onSubmit}>{children}</CustomForm>
);
