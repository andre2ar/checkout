import classes from './Main.module.css';

export function Main(props) {
    return (
        <main className={classes.Main}>
            {props.children}
        </main>
    );
}
