import TaskCard from "@/components/ui/task-card";
import { TTask } from "@/types/Task";
import fetchWrapper from "@/wrappers/fetchWrapper";

export default async function Home() {
  const getTasks = await fetchWrapper("/api/tasks", {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  });

  const tasks = (await getTasks.json()) as TTask[];

  return (
    <main className="container mx-auto p-4">
      <h1 className="text-2xl font-bold text-center">Tasks</h1>

      <div className="p-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        {tasks.map((task) => (
          <TaskCard
            key={task.id}
            id={task.id}
            title={task.title}
            description={task.description}
            status={task.status}
          />
        ))}
      </div>
    </main>
  );
}
