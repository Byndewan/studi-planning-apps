export function safeAlpineComponent(name, component) {
    return function() {
        try {
            const instance = typeof component === 'function' ? component() : component;

            if (instance.init) {
                const originalInit = instance.init;
                instance.init = function() {
                    try {
                        if (!this.$el) {
                            console.warn(`Alpine component "${name}" element not found`);
                            return;
                        }
                        originalInit.call(this);
                    } catch (e) {
                        console.warn(`Alpine component "${name}" init error:`, e.message);
                    }
                };
            }

            return instance;
        } catch (e) {
            console.error(`Alpine component "${name}" creation error:`, e.message);
            return {};
        }
    };
}

export function safeOn(event, element, handler) {
    if (element && element.addEventListener) {
        element.addEventListener(event, handler);
    } else if (typeof element === 'string') {
        document.addEventListener(event, (e) => {
            if (e.target.matches(element)) {
                handler(e);
            }
        });
    }
}
