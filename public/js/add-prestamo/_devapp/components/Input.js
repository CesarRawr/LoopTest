const Input = (props) => {
  const handleClick = (event) => event.target.select();

  return (
    <input 
      className="listInput" 
      style={props.styles} 
      disabled={props.disabled}
      placeholder={props.placeholder} 
      onClick={props.select ? handleClick: undefined}
      autoComplete={!props.autocomplete ? "on": props.autocomplete} 
      value={props.value}
      onChange={props.onChange}
      />
  );
}
