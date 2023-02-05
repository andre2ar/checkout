import classes from './Button.module.css';

export function Button(props) {
    return (
        <button
            type={props.type ?? 'button'}
            className={classes.Button}
            onClick={props.onClick}
        >
            {props.children}
        </button>
    );
}
