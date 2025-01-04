interface TaskCardProps {
  id: string;
  title: string;
  description: string;
  status: string;
}

const TaskCard: React.FC<TaskCardProps> = ({
  id,
  title,
  description,
  status,
}) => {
  return (
    <div className="border p-4 rounded shadow" key={id}>
      <h2 className="text-lg font-bold">{title}</h2>
      <p className="text-sm">{description}</p>
      <span className="text-gray-600 text-xs">
        Status: {status.charAt(0).toUpperCase() + status.slice(1)}
      </span>
    </div>
  );
};

export default TaskCard;
