import React, { useState, useEffect } from 'react';
import { Image, View, Dimensions, ActivityIndicator } from 'react-native';

const AutoSizeRemoteImage = ({ uri, basewidth }) => {
    const [height, setHeight] = useState(0);
    const [width, setWidth] = useState(0);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        setWidth(basewidth);
        if (uri) {
            Image.getSize(
                uri,
                (originalWidth, originalHeight) => {
                    const ratio = originalHeight / originalWidth;
                    setHeight(basewidth * ratio);
                    setLoading(false);
                },
                (error) => {
                    console.error('Image size error:', error);
                    setLoading(false);
                }
            );
        }
    }, [uri]);

    if (loading) {
        return <ActivityIndicator />;
    }

    return (
        <Image
            source={{ uri }}
            style={{
            width: width,
            height: height,
            resizeMode: 'contain',
        }}
        />
    );
};

export default AutoSizeRemoteImage;