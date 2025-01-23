const dragList = document.getElementById("dragList");
let draggedItem = null;

// Add event listeners for drag and drop events
dragList.addEventListener("dragstart", handleDragStart);
dragList.addEventListener("dragover", handleDragOver);
dragList.addEventListener("drop", handleDrop);

// Drag start event handler
function handleDragStart(event) {
    draggedItem = event.target;
    event.dataTransfer.effectAllowed = "move";
    event.dataTransfer.setData("text/html", draggedItem.innerHTML);
    event.target.style.opacity = "0.5";
}

// Drag over event handler
function handleDragOver(event) {
    event.preventDefault();
    event.dataTransfer.dropEffect = "move";
    const targetItem = event.target;
    if (
        targetItem !== draggedItem &&
        targetItem.classList.contains("drag-item")
    ) {
        const boundingRect = targetItem.getBoundingClientRect();
        const offset = boundingRect.y + boundingRect.height / 2;
        if (event.clientY - offset > 0) {
            targetItem.style.borderBottom = "solid 2px #000";
            targetItem.style.borderTop = "";
        } else {
            targetItem.style.borderTop = "solid 2px #000";
            targetItem.style.borderBottom = "";
        }
    }
}

// Drop event handler
function handleDrop(event) {
    event.preventDefault();
    const targetItem = event.target;
    if (
        targetItem !== draggedItem &&
        targetItem.classList.contains("drag-item")
    ) {
        if (
            event.clientY >
            targetItem.getBoundingClientRect().top + targetItem.offsetHeight / 2
        ) {
            targetItem.parentNode.insertBefore(
                draggedItem,
                targetItem.nextSibling
            );
        } else {
            targetItem.parentNode.insertBefore(draggedItem, targetItem);
        }
    }
    targetItem.style.borderTop = "";
    targetItem.style.borderBottom = "";
    draggedItem.style.opacity = "";
    draggedItem = null;

    // updateOrder();
}

function updateOrder(frm) {
    const orderedItems = Array.from(dragList.children).map(item => item.dataset.id);
    console.log("New Order:", orderedItems);
    frm.new_order.value = JSON.stringify(orderedItems);
    return true;
}
