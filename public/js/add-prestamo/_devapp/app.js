const App = () => {
  const {ThemeProvider, createTheme, colors} = MaterialUI;
  const theme = createTheme({
    palette: {
      primary: {
        main: '#556cd6',
      },
      secondary: {
        main: '#19857b',
      },
      error: {
        main: colors.red.A400,
      },
    },
  });

  return (
    <ThemeProvider theme={theme}>
      <div 
        style={{
          height: '100%', 
          display: 'flex', 
          justifyContent: 'center', 
          alignItems: 'center'
        }}>

        <CreateLoanFeature />
      </div>
    </ThemeProvider>
  );
}

const container = document.getElementById('app');
const root = ReactDOM.createRoot(container);
root.render(<App />);