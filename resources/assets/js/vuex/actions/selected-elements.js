export const SelectElement = ({dispatch, state}, element) => {
    if (isSelectedElement({dispatch, state}, element)) {
        state.selectedElements.elements.$remove(element.id);
    }
    else {
        state.selectedElements.elements.push(element.id);
    }
}

export const isSelectedElement = ({dispatch, state}, element) => {
    if (state.selectedElements.elements.indexOf(element.id) !== -1) {
        return true;
    }
    else {
        return false;
    }
}

export const clearAllSelected = ({dispatch, state}) => {
    dispatch('SET_SELECTED_ELEMENTS', []);
}