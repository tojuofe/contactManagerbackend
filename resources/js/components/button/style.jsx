import styled from "styled-components";

const mainColor = "blue";

export const CustomButton = styled.button`
    border-radius: 3px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    text-transform: uppercase;
    font-family: inherit;
    font-weight: bold;
    font-size: 14px;
    padding: 10px;
    margin: 20px 0;
    width: 100%;
    background-color: ${mainColor};
    border: 2px solid transparent;
    color: #fff;

    &:hover {
        opacity: 0.8;
    }
`;
