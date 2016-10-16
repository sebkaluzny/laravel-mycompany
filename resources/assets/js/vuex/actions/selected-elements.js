export const SelectElement = ({dispatch, state}, e, element) => {
    // if(!state.selectedElements.lastChecked) {
    //     state.selectedElements.lastChecked = element;
    //     return;
    // }
    //
    // if(e != null && e.shiftKey) {
    //     var start = $chkboxes.index(this);
    //     var end = $chkboxes.index(lastChecked);
    //
    //     $chkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).prop('checked', lastChecked.checked);
    //
    // }

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