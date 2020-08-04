import styled from "styled-components";
import { Link } from "react-router-dom";

const linkColor = "#fb8200";

export const Container = styled.div`
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 3px;
    height: 100vh;
    background-color: #f7f8fc;
    font-family: "Open Sans", sans-serif;

    @media screen and (max-width: 768px) {
        flex-direction: column;
        height: 750px;
    }
`;

export const Card = styled.div`
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    background-color: #fff;
    border: 3px solid #dce7ff;
    border-radius: 3px;
    width: 1000px;
    box-shadow: 0 4px 5px rgba(0, 0, 0, 0.1);

    @media screen and (max-width: 768px) {
        grid-template-columns: 1fr;
        width: 330px;
        margin-bottom: 10rem;
    }
`;

export const CustomCard = styled.div`
    background-color: #fff;
    border: 3px solid #dce7ff;
    border-radius: 3px;
    width: 500px;
    box-shadow: 0 4px 5px rgba(0, 0, 0, 0.1);

    @media screen and (max-width: 768px) {
        width: auto;
    }
`;

export const FormControl = styled.div`
    margin: 10px 0;
    width: 100%;

    .label {
        display: inline-block;
        font-weight: bold;
        margin-bottom: 5px;
    }
`;

export const FormUsername = styled.div`
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-gap: 3.5rem;
`;

export const CheckBoxContainer = styled.div`
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    margin-bottom: 15px;
    width: 100%;

    label {
        color: #7a7e8c;
        font-weight: normal;
        margin-left: 2px;
    }

    span {
        position: relative;
        padding-left: 5px;
        font-size: 14px;
        line-height: 10px;
    }
`;

export const CustomLink = styled(Link)`
    color: ${linkColor};
`;
