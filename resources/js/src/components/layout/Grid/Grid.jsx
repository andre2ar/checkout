import classes from './Grid.module.css';

export function Grid(props) {
    return (
        <div className={classes.Grid}>
            {props.children}
        </div>
    );
}
