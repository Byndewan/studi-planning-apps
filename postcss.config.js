export default {
    plugins: {
        'postcss-import': {},
        autoprefixer: {},
        'postcss-preset-env': {
            stage: 3,
            features: {
                'nesting-rules': true,
            },
        },
        cssnano: {
            preset: 'default',
            autoprefixer: false,
            reduceIdents: false,
            zindex: false,
            discardComments: {
                removeAll: true,
            },
        },
    },
};
