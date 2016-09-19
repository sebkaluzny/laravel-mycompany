export const triggerLoadAnimation = ({ dispatch }) => {
    dispatch('TRIGGER_LOAD_ANIMATION');
};

export const triggerLoadAnimationDone = ({ dispatch }) => {
    dispatch('TRIGGER_LOAD_ANIMATION_DONE');
    setTimeout(() => {
        dispatch('HIDE_LOAD_ANIMATION');
    }, 600);
};