const AlertDialog = (props) => {
  return (
    <MaterialUI.Dialog
      open={props.isOpen}
      onClose={props.handleClose}
      aria-labelledby="alert-dialog-title"
      aria-describedby="alert-dialog-description"
    >
      <MaterialUI.DialogTitle id="alert-dialog-title">
        {
          props.title
        }
      </MaterialUI.DialogTitle>
      <MaterialUI.DialogContent>
        <MaterialUI.DialogContentText id="alert-dialog-description">
          {
            props.description
          }
        </MaterialUI.DialogContentText>
      </MaterialUI.DialogContent>
      <MaterialUI.DialogActions>
        <MaterialUI.Button onClick={props.handleClose} autoFocus>
          Cerrar
        </MaterialUI.Button>
      </MaterialUI.DialogActions>
    </MaterialUI.Dialog>
  );
}
