const MultiSelector = (props) => {
  const customStyles = {
    control: (provided, state) => ({
      ...provided,
      background: '#fafafa',
      borderColor: '#d1d1d1',
      minHeight: '4.5vh',
      border: "1px solid #d1d1d1",
      borderRadius: "4px",
      boxShadow: state.isFocused ? null : null,
      fontSize: "16px",
      ...props.styles,
    }),
    valueContainer: (provided, state) => ({
      ...provided,
      minHeight: '30px',
      padding: '0 6px'
    }),
    input: (provided, state) => ({
      ...provided,
      margin: '0px',
    }),
    indicatorSeparator: (state) => ({
      display: 'none',
    }),
    indicatorsContainer: (provided, state) => ({
      ...provided,
      display: 'none',
    }),
  };

  return (
    <div>
      <Select 
        styles={customStyles}
        options={props.options} 
        name={props.name} 
        placeholder={props.placeholder}
        onChange={props.onChange}
        value={props.values}
        hideSelectedOptions={false}
        isOptionSelected={() => false}
        theme={(theme) => ({
          ...theme,
          borderRadius: 0,
          colors: {
            ...theme.colors,
            primary25: '#f1f1f1',
            primary50: '#f1f1f1',
          },
        })} 
        isMulti />
    </div>
  );
}
