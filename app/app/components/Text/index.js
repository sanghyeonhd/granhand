import React, { Component } from "react";
import { Text, StyleSheet } from "react-native";
import PropTypes from "prop-types";
import { Typography, FontWeight, FontFamily, BaseColor } from "@config";

export default class Index extends Component {
    constructor(props) {
        super(props);
    }
    render() {
        const {
            style,
            numberOfLines,
        } = this.props;
        return (
            <Text style={style}
                numberOfLines={numberOfLines}
            >
                {this.props.children}
            </Text>
        );
    }
}