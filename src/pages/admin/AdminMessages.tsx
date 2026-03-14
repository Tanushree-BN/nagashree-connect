import { useState } from "react";
import { Eye, Trash2, Mail, MailOpen } from "lucide-react";
import { getMessages, markMessageSeen, deleteMessage } from "@/lib/store";

const AdminMessages = () => {
  const [messages, setMessages] = useState(getMessages());
  const [viewId, setViewId] = useState<string | null>(null);

  const refresh = () => setMessages(getMessages());

  const handleView = (id: string) => {
    markMessageSeen(id);
    setViewId(viewId === id ? null : id);
    refresh();
  };

  const handleDelete = (id: string) => {
    if (confirm("Delete this message?")) {
      deleteMessage(id);
      setViewId(null);
      refresh();
    }
  };

  const unseen = messages.filter((m) => !m.seen).length;

  return (
    <div>
      <div className="flex items-center justify-between mb-6">
        <div>
          <h1 className="font-display text-2xl font-bold text-foreground">Contact Messages</h1>
          {unseen > 0 && <p className="text-gold text-sm mt-1">{unseen} new message{unseen > 1 ? "s" : ""}</p>}
        </div>
      </div>

      {messages.length === 0 ? (
        <div className="bg-card rounded-xl border border-border p-12 text-center">
          <Mail className="w-12 h-12 text-muted-foreground mx-auto mb-3" />
          <p className="text-muted-foreground">No messages yet. Messages sent via the Contact page will appear here.</p>
        </div>
      ) : (
        <div className="space-y-3">
          {messages.map((msg) => (
            <div key={msg.id} className={`bg-card rounded-xl border ${msg.seen ? "border-border" : "border-gold"} overflow-hidden`}>
              <div className="flex items-center justify-between px-5 py-4 cursor-pointer hover:bg-muted/50" onClick={() => handleView(msg.id)}>
                <div className="flex items-center gap-3">
                  {msg.seen ? <MailOpen className="w-4 h-4 text-muted-foreground" /> : <Mail className="w-4 h-4 text-gold" />}
                  <div>
                    <span className={`font-medium text-sm ${msg.seen ? "text-foreground" : "text-foreground font-semibold"}`}>{msg.name}</span>
                    <span className="text-muted-foreground text-xs ml-3">{msg.subject}</span>
                  </div>
                </div>
                <div className="flex items-center gap-2">
                  <span className="text-muted-foreground text-xs">{new Date(msg.date).toLocaleDateString()}</span>
                  <button onClick={(e) => { e.stopPropagation(); handleDelete(msg.id); }} className="p-1 text-muted-foreground hover:text-destructive"><Trash2 className="w-4 h-4" /></button>
                </div>
              </div>
              {viewId === msg.id && (
                <div className="px-5 pb-5 border-t border-border pt-4 space-y-2 text-sm">
                  <p><span className="text-muted-foreground">Email:</span> <span className="text-foreground">{msg.email}</span></p>
                  {msg.phone && <p><span className="text-muted-foreground">Phone:</span> <span className="text-foreground">{msg.phone}</span></p>}
                  <p className="text-foreground leading-relaxed mt-3">{msg.message}</p>
                </div>
              )}
            </div>
          ))}
        </div>
      )}
    </div>
  );
};

export default AdminMessages;
